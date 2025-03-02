from django.contrib import admin
from .models import APIKey

class APIKeyAdmin(admin.ModelAdmin):
    list_display = ('user', 'key', 'created_at', 'expires_at', 'is_active')
    list_filter = ('is_active',)
    search_fields = ('user__username', 'key')
    readonly_fields = ('key', 'created_at')

admin.site.register(APIKey, APIKeyAdmin)
