from django.urls import path
from . import views

app_name = 'api'

urlpatterns = [
    path('key-info/', views.user_key_info, name='key_info'),
    path('generate-key/', views.generate_api_key, name='generate_key'),
    path('stats/', views.test_statistics, name='test_statistics'),
    path('stats/<int:test_id>/', views.test_statistics, name='test_statistics_detail'),
] 