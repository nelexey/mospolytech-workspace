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
