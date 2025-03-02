from django.urls import path
from . import views

app_name = 'api'

urlpatterns = [
    path('stats/', views.TestStatsView.as_view(), name='test_stats'),
    path('key-info/', views.user_key_info, name='key_info'),
    path('generate-key/', views.generate_api_key, name='generate_key'),
] 