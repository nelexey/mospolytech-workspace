from django.db import models
from django.utils import timezone


class Test(models.Model):
    DIFFICULTY_CHOICES = [
        ('easy', 'Easy'),
        ('medium', 'Medium'),
        ('hard', 'Hard')
    ]

    owner = models.ForeignKey('users.User', on_delete=models.CASCADE)
    title = models.CharField(max_length=255)
    description = models.TextField(blank=True)
    test = models.JSONField()
    difficulty = models.CharField(max_length=50, choices=DIFFICULTY_CHOICES, default='medium')
    duration = models.IntegerField(null=True)  # in minutes
    attempts_allowed = models.IntegerField(default=1)
    is_published = models.BooleanField(default=False)
    category = models.CharField(max_length=255, blank=True)
    time_created = models.DateTimeField(default=timezone.now)
    time_updated = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'tests'


class TestStatistics(models.Model):
    user = models.ForeignKey('users.User', on_delete=models.CASCADE)
    test = models.ForeignKey(Test, on_delete=models.CASCADE)
    result = models.IntegerField()
    max_result = models.IntegerField()
    time_spent = models.IntegerField(null=True)  # in seconds
    date_taken = models.DateTimeField(default=timezone.now)
    passed = models.BooleanField()
    attempt_number = models.IntegerField(default=1)
    percentage = models.FloatField(null=True)  # We'll calculate this in save()

    def save(self, *args, **kwargs):
        if self.result is not None and self.max_result:
            self.percentage = (self.result * 100.0) / self.max_result
        super().save(*args, **kwargs)

    class Meta:
        db_table = 'statistics'
        unique_together = ('user', 'test', 'attempt_number')