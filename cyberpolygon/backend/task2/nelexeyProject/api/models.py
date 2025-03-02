from django.db import models
from django.utils import timezone
import uuid
from users.models import User

# Create your models here.

class APIKey(models.Model):
    key = models.CharField(max_length=64, unique=True)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    description = models.TextField(blank=True)
    created_at = models.DateTimeField(default=timezone.now)
    expires_at = models.DateTimeField(null=True, blank=True)
    is_active = models.BooleanField(default=True)

    class Meta:
        db_table = 'api_key'
        verbose_name = 'API Key'
        verbose_name_plural = 'API Keys'

    def __str__(self):
        return f"{self.user.username}'s API Key"
    
    @classmethod
    def generate_key(cls, user, description=''):
        """Generate a new API key for a user"""
        key = uuid.uuid4().hex
        return cls.objects.create(
            key=key,
            user=user,
            description=description
        )
    
    @classmethod
    def get_or_create_key(cls, user, description=''):
        """Get existing key or create a new one for a user"""
        existing_key = cls.objects.filter(user=user, is_active=True).first()
        if existing_key:
            return existing_key
        return cls.generate_key(user, description)
