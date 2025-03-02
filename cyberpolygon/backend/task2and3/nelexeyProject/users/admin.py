from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
from .models import User


class CustomUserAdmin(UserAdmin):
    list_display = ('username', 'email', 'name', 'surname', 'role', 'status', 'email_verified', 'last_login')
    list_filter = ('role', 'status', 'email_verified')
    search_fields = ('username', 'email', 'name', 'surname')
    ordering = ('username',)

    fieldsets = (
        (None, {'fields': ('username', 'password')}),
        ('Personal info', {'fields': ('email', 'name', 'surname', 'avatar_url')}),
        ('Permissions', {'fields': ('role', 'status', 'email_verified')}),
        ('Important dates', {'fields': ('last_login', 'created_at', 'updated_at')}),
    )

    readonly_fields = ('created_at', 'updated_at')

    add_fieldsets = (
        (None, {
            'classes': ('wide',),
            'fields': ('username', 'email', 'password1', 'password2', 'role', 'status'),
        }),
    )


admin.site.register(User, CustomUserAdmin)