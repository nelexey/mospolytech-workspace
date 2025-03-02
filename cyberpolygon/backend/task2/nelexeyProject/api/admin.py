from django.contrib import admin
from .models import APIKey

@admin.register(APIKey)
class APIKeyAdmin(admin.ModelAdmin):
    list_display = ('user', 'created_at', 'last_used', 'is_active')
    list_filter = ('is_active', 'created_at')
    search_fields = ('user__username', 'user__email')
    readonly_fields = ('key', 'created_at', 'last_used')
    
    def has_delete_permission(self, request, obj=None):
        # Запретить удаление, чтобы пользователи не потеряли доступ к API
        return False
