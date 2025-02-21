from django.shortcuts import render

def home(request):
    user = request.user

    context = {
        'is_authenticated': user.is_authenticated,
        'username': user.username if user.is_authenticated else None,
        'role': user.role if user.is_authenticated and hasattr(user, 'role') else None,
    }
    return render(request, 'core/home.html', context)