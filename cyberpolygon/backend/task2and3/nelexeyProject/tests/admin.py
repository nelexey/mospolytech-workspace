from django.contrib import admin
from .models import Test, TestStatistics


class TestStatisticsInline(admin.TabularInline):
    model = TestStatistics
    extra = 0
    readonly_fields = ('percentage',)
    can_delete = False
    max_num = 0
    fields = ('user', 'result', 'max_result', 'percentage', 'time_spent', 'passed', 'attempt_number', 'date_taken')


@admin.register(Test)
class TestAdmin(admin.ModelAdmin):
    list_display = ('title', 'owner', 'category', 'difficulty', 'is_published', 'attempts_allowed', 'time_created')
    list_filter = ('difficulty', 'is_published', 'category')
    search_fields = ('title', 'description', 'owner__username')
    date_hierarchy = 'time_created'
    readonly_fields = ('time_created', 'time_updated')

    fieldsets = (
        (None, {
            'fields': ('title', 'description', 'owner')
        }),
        ('Test Settings', {
            'fields': ('test', 'category', 'difficulty', 'duration', 'attempts_allowed')
        }),
        ('Status', {
            'fields': ('is_published', 'time_created', 'time_updated')
        }),
    )

    inlines = [TestStatisticsInline]


@admin.register(TestStatistics)
class TestStatisticsAdmin(admin.ModelAdmin):
    list_display = ('user', 'test', 'result', 'max_result', 'percentage', 'passed', 'attempt_number', 'date_taken')
    list_filter = ('passed', 'test', 'date_taken')
    search_fields = ('user__username', 'test__title')
    readonly_fields = ('percentage',)
    date_hierarchy = 'date_taken'

    fieldsets = (
        (None, {
            'fields': ('user', 'test', 'attempt_number')
        }),
        ('Results', {
            'fields': ('result', 'max_result', 'percentage', 'passed')
        }),
        ('Time Information', {
            'fields': ('time_spent', 'date_taken')
        }),
    )