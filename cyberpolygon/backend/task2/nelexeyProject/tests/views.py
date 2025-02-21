from django.shortcuts import render, get_object_or_404, redirect
from django.contrib.auth.decorators import login_required
from django.http import JsonResponse
from django.contrib import messages
from .models import Test, TestStatistics
from django.db.models import Q


def test_list(request):
    tests = Test.objects.filter(is_published=True).select_related('owner')

    category = request.GET.get('category')
    difficulty = request.GET.get('difficulty')
    search = request.GET.get('search')

    if category:
        tests = tests.filter(category=category)
    if difficulty:
        tests = tests.filter(difficulty=difficulty)
    if search:
        tests = tests.filter(Q(title__icontains=search) | Q(description__icontains=search))

    return render(request, 'tests/test_list.html', {'tests': tests})


def test_detail(request, test_id):
    test = get_object_or_404(Test, id=test_id, is_published=True)

    if request.user.is_authenticated:
        attempts = TestStatistics.objects.filter(user=request.user, test=test)
        attempts_left = test.attempts_allowed - attempts.count()
    else:
        attempts = None
        attempts_left = test.attempts_allowed

    context = {
        'test': test,
        'attempts': attempts,
        'attempts_left': attempts_left
    }
    return render(request, 'tests/test_detail.html', context)


def calculate_test_result(test, answers):
    test_data = test.test
    total_score = 0
    max_score = 0

    for idx, question in enumerate(test_data['questions']):
        q_num = idx
        q_type = question.get('type', 'unknown')
        q_points = question.get('points', 1)
        correct_answers = question.get('answers', [])

        if q_type == 'text':
            user_answer = answers.get(f'q{q_num}', '')
            if user_answer == correct_answers[0]:
                total_score += q_points
        elif q_type == 'radioButton':
            user_answer = answers.get(f'q{q_num}', '')
            try:
                user_answer_int = int(user_answer)
                if user_answer_int in correct_answers:
                    total_score += q_points
            except ValueError:
                pass
        elif q_type == 'checkbox':
            user_answers = answers.getlist(f'q{q_num}', [])
            try:
                user_answers_int = [int(ans) for ans in user_answers]
                if set(user_answers_int) == set(correct_answers):
                    total_score += q_points
            except ValueError:
                pass
        else:
            pass

        max_score += q_points

    time_spent = int(answers.get('time_spent', 0))
    return {
        'score': total_score,
        'max_score': max_score,
        'time_spent': time_spent,
    }

@login_required
def test_attempt(request, test_id, attempt):
    test = get_object_or_404(Test, id=test_id, is_published=True)
    attempts = TestStatistics.objects.filter(user=request.user.id, test=test).count()
    if attempts >= test.attempts_allowed:
        messages.error(request, 'Достигнут максимальный лимит попыток')
        return redirect('tests:test_detail', test_id=test_id)

    if request.method == 'POST':
        answers = request.POST
        result = calculate_test_result(test, answers)
        passed = result['score'] >= 0.5 * result['max_score']
        TestStatistics.objects.create(
            user=request.user,
            test=test,
            result=result['score'],
            max_result=result['max_score'],
            time_spent=result['time_spent'],
            passed=passed,
            attempt_number=attempts + 1
        )
        messages.success(request, f'Твой результат: {result["score"]}/{result["max_score"]}')
        return redirect('tests:test_detail', test_id=test_id)

    context = {
        'test': test,
        'attempt_number': attempts + 1
    }
    return render(request, 'tests/test_attempt.html', context)
