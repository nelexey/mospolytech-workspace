from django.urls import path
from . import views

app_name = 'tests'

urlpatterns = [
    path('tests/', views.test_list, name='test_list'),
    path('test/<int:test_id>/', views.test_detail, name='test_detail'),
    path('test/<int:test_id>/<int:attempt>/', views.test_attempt, name='test_attempt'),
]
