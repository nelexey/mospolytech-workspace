from django.shortcuts import render, redirect, get_object_or_404
from django.contrib.auth import login, logout
from django.db.models import Avg
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from .forms import UserRegistrationForm, UserLoginForm
from .models import User
from tests.models import TestStatistics


def register_view(request):
    if request.user.is_authenticated:
        return redirect('users:user_home')

    if request.method == 'POST':
        form = UserRegistrationForm(request.POST)
        if form.is_valid():
            user = form.save()
            login(request, user)
            messages.success(request, 'Регистрация успешна!')
            return redirect('users:user_home')
    else:
        form = UserRegistrationForm()
    return render(request, 'users/register.html', {'form': form})


def login_view(request):
    if request.user.is_authenticated:
        return redirect('users:user_home')

    if request.method == 'POST':
        form = UserLoginForm(data=request.POST)
        if form.is_valid():
            user = form.get_user()
            login(request, user)
            return redirect('users:user_home')
    else:
        form = UserLoginForm()
    return render(request, 'users/login.html', {'form': form})


def logout_view(request):
    logout(request)
    return redirect('core:home')


@login_required
def user_home(request):
    user_stats = TestStatistics.objects.filter(user=request.user).select_related('test')

    context = {
        'recent_attempts': user_stats.order_by('-date_taken')[:5],
        'total_tests_taken': user_stats.count(),
        'average_score': user_stats.aggregate(Avg('percentage'))['percentage__avg']
    }
    return render(request, 'users/home.html', context)


def user_profile(request, username):
    user = get_object_or_404(User, username=username)
    stats = TestStatistics.objects.filter(user=user).select_related('test')
    context = {
        'profile_user': user,
        'stats': stats,
        'tests_taken': stats.count(),
        'average_score': stats.aggregate(Avg('percentage'))['percentage__avg']
    }
    return render(request, 'users/profile.html', context)