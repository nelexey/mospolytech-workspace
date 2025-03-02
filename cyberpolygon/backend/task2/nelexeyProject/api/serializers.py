from rest_framework import serializers
from tests.models import Test, TestStatistics
from users.models import User

class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = User
        fields = ('id', 'username', 'email', 'name', 'surname')


class TestSerializer(serializers.ModelSerializer):
    owner = UserSerializer(read_only=True)
    
    class Meta:
        model = Test
        fields = ('id', 'title', 'description', 'difficulty', 'owner', 
                  'duration', 'attempts_allowed', 'is_published', 'category', 
                  'time_created', 'time_updated')


class TestStatisticsSerializer(serializers.ModelSerializer):
    test = TestSerializer(read_only=True)
    user = UserSerializer(read_only=True)
    
    class Meta:
        model = TestStatistics
        fields = ('id', 'user', 'test', 'result', 'max_result', 'percentage',
                  'time_spent', 'date_taken', 'passed', 'attempt_number')


class TestStatsSummarySerializer(serializers.Serializer):
    total_tests = serializers.IntegerField()
    published_tests = serializers.IntegerField()
    total_attempts = serializers.IntegerField()
    passed_attempts = serializers.IntegerField()
    success_rate = serializers.FloatField()
    average_score = serializers.FloatField()
    tests_by_difficulty = serializers.DictField(
        child=serializers.IntegerField()
    )
    tests_by_category = serializers.DictField(
        child=serializers.IntegerField()
    ) 