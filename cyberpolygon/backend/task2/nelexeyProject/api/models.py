from django.db import models
from django.utils import timezone
import uuid

# Create your models here.

class APIKey(models.Model):
    user = models.OneToOneField('users.User', on_delete=models.CASCADE, related_name='api_key')
    key = models.CharField(max_length=64, unique=True, editable=False)
    created_at = models.DateTimeField(default=timezone.now)
    last_used = models.DateTimeField(null=True, blank=True)
    is_active = models.BooleanField(default=True)

    @classmethod
    def generate_key(cls):
        """Generate a random API key."""
        return uuid.uuid4().hex

    def save(self, *args, **kwargs):
        if not self.key:
            self.key = self.generate_key()
        return super().save(*args, **kwargs)

    def __str__(self):
        return f"API Key for {self.user.username}"
    
    class Meta:
        db_table = 'api_keys'
        verbose_name = 'API Key'
        verbose_name_plural = 'API Keys'
