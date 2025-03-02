from django.shortcuts import render, redirect
from django.db.models import Count, Avg, Sum, F, Q
from django.utils import timezone
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from rest_framework import views, status, permissions
from rest_framework.response import Response
from rest_framework.decorators import api_view, permission_classes
from tests.models import Test, TestStatistics
from .models import APIKey
from .serializers import (
    TestSerializer, TestStatisticsSerializer, TestStatsSummarySerializer
)
from django.http import JsonResponse
from django.views.decorators.http import require_http_methods
from django.shortcuts import get_object_or_404
from django.db.models import FloatField, ExpressionWrapper


class APIKeyPermission(permissions.BasePermission):
    """
    Проверка API ключа в заголовке запроса
    """
    def has_permission(self, request, view):
        api_key = request.META.get('HTTP_X_API_KEY', '')
        if not api_key:
            return False
        
        try:
            key = APIKey.objects.get(key=api_key, is_active=True)
            # Обновляем время последнего использования
            key.last_used = timezone.now()
            key.save(update_fields=['last_used'])
            
            # Прикрепляем пользователя к запросу
            request.user = key.user
            return key.user.role == 'tester'
        except APIKey.DoesNotExist:
            return False


class TestStatsView(views.APIView):
    """
    API для получения статистики по тестам
    """
    permission_classes = [APIKeyPermission]
    
    def get(self, request):
        # Получаем базовую статистику
        total_tests = Test.objects.count()
        published_tests = Test.objects.filter(is_published=True).count()
        
        # Статистика по попыткам
        total_attempts = TestStatistics.objects.count()
        passed_attempts = TestStatistics.objects.filter(passed=True).count()
        
        # Рассчитываем показатели
        success_rate = (passed_attempts / total_attempts * 100) if total_attempts > 0 else 0
        average_score = TestStatistics.objects.aggregate(avg_score=Avg('percentage'))['avg_score'] or 0
        
        # Группировка тестов по сложности
        tests_by_difficulty = {
            item['difficulty']: item['count'] 
            for item in Test.objects.values('difficulty').annotate(count=Count('id'))
        }
        
        # Группировка тестов по категориям
        tests_by_category = {
            item['category'] or 'Без категории': item['count'] 
            for item in Test.objects.values('category').annotate(count=Count('id'))
        }
        
        # Создаем результат
        data = {
            'total_tests': total_tests,
            'published_tests': published_tests,
            'total_attempts': total_attempts,
            'passed_attempts': passed_attempts,
            'success_rate': round(success_rate, 2),
            'average_score': round(average_score, 2),
            'tests_by_difficulty': tests_by_difficulty,
            'tests_by_category': tests_by_category
        }
        
        serializer = TestStatsSummarySerializer(data)
        return Response(serializer.data)


@api_view(['GET'])
@permission_classes([APIKeyPermission])
def user_key_info(request):
    """
    Возвращает информацию о текущем API ключе пользователя
    """
    key = APIKey.objects.get(user=request.user)
    return Response({
        'key': key.key,
        'created_at': key.created_at,
        'last_used': key.last_used,
        'is_active': key.is_active
    })


@login_required
def generate_api_key(request):
    """
    Генерирует или отображает API ключ для пользователя с ролью tester
    """
    # Проверяем, что пользователь имеет роль tester
    if request.user.role != 'tester':
        messages.error(request, 'Только пользователи с ролью tester могут получить API ключ')
        return redirect('home')
    
    # Проверяем, есть ли уже ключ
    api_key, created = APIKey.objects.get_or_create(user=request.user)
    
    if created:
        messages.success(request, 'API ключ успешно создан')
    else:
        messages.info(request, 'У вас уже есть API ключ')
    
    return render(request, 'api/api_key.html', {'api_key': api_key})


def get_api_key_from_request(request):
    """Extract API key from request headers or query parameters"""
    api_key = request.headers.get('X-API-Key') or request.GET.get('api_key')
    return api_key


def api_key_required(view_func):
    """Decorator to check if a valid API key is provided"""
    def wrapper(request, *args, **kwargs):
        api_key_value = get_api_key_from_request(request)
        
        # Отладочная информация
        print(f"Request headers: {dict(request.headers)}")
        print(f"Query parameters: {request.GET}")
        print(f"API key from request: {api_key_value}")
        
        if not api_key_value:
            return JsonResponse({'error': 'API ключ не предоставлен'}, status=401)
        
        try:
            api_key = APIKey.objects.get(key=api_key_value, is_active=True)
            print(f"API key found: {api_key}, User: {api_key.user.username}, Role: {api_key.user.role}")
            request.api_key = api_key
            request.user = api_key.user
            return view_func(request, *args, **kwargs)
        except APIKey.DoesNotExist:
            print(f"API key not found: {api_key_value}")
            return JsonResponse({'error': 'Недействительный API ключ'}, status=401)
    
    return wrapper


@require_http_methods(["GET"])
@api_key_required
def test_statistics(request, test_id=None):
    """
    Get statistics for tests
    
    If test_id is provided, get statistics for specific test
    Otherwise get statistics for all tests owned by the user
    """
    user = request.user
    
    # Проверяем, является ли пользователь тестером
    if user.role != 'tester':
        return JsonResponse({'error': 'Доступ запрещен. Только тестеры могут получать статистику тестов.'}, status=403)
    
    if test_id:
        # Получаем статистику для конкретного теста
        test = get_object_or_404(Test, id=test_id, owner=user)
        
        # Собираем общую статистику по тесту
        stats = TestStatistics.objects.filter(test=test)
        
        # Рассчитываем средний балл в процентах
        avg_score_expression = ExpressionWrapper(
            Sum(F('result')) * 100.0 / Sum(F('max_result')),
            output_field=FloatField()
        )
        
        aggregated_stats = stats.aggregate(
            total_attempts=Count('id'),
            avg_score_percent=avg_score_expression,
            avg_time_seconds=Avg('time_spent'),
        )
        
        # Собираем детальную статистику по попыткам
        detailed_stats = []
        for stat in stats:
            detailed_stats.append({
                'user_id': stat.user.id,
                'username': stat.user.username,
                'attempt_number': stat.attempt_number,
                'score': stat.result,
                'max_score': stat.max_result,
                'percent': round((stat.result / stat.max_result * 100), 2) if stat.max_result > 0 else 0,
                'time_spent': stat.time_spent,
                'date_completed': stat.date_taken,
            })
        
        response_data = {
            'test_id': test.id,
            'test_title': test.title,
            'summary': {
                'total_attempts': aggregated_stats['total_attempts'],
                'avg_score_percent': round(aggregated_stats['avg_score_percent'] or 0, 2),
                'avg_time_seconds': round(aggregated_stats['avg_time_seconds'] or 0, 2),
            },
            'attempts': detailed_stats
        }
        
    else:
        # Получаем статистику для всех тестов пользователя
        tests = Test.objects.filter(owner=user)
        
        tests_stats = []
        for test in tests:
            # Собираем статистику для каждого теста
            stats = TestStatistics.objects.filter(test=test)
            
            # Рассчитываем средний балл в процентах
            avg_score_expression = ExpressionWrapper(
                Sum(F('result')) * 100.0 / Sum(F('max_result')),
                output_field=FloatField()
            )
            
            aggregated_stats = stats.aggregate(
                total_attempts=Count('id'),
                avg_score_percent=avg_score_expression,
                avg_time_seconds=Avg('time_spent'),
            )
            
            tests_stats.append({
                'test_id': test.id,
                'test_title': test.title,
                'total_attempts': aggregated_stats['total_attempts'],
                'avg_score_percent': round(aggregated_stats['avg_score_percent'] or 0, 2),
                'avg_time_seconds': round(aggregated_stats['avg_time_seconds'] or 0, 2),
            })
        
        response_data = {
            'tests_count': len(tests),
            'tests': tests_stats
        }
    
    return JsonResponse(response_data)
