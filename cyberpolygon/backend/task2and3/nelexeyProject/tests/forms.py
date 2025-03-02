from django import forms
from .models import Test

class TestCreationForm(forms.ModelForm):
    class Meta:
        model = Test
        fields = ['title', 'description', 'category', 'difficulty',
                  'duration', 'attempts_allowed', 'is_published']
        widgets = {
            'description': forms.Textarea(attrs={'rows': 4}),
            'duration': forms.NumberInput(attrs={'min': 1}),
            'attempts_allowed': forms.NumberInput(attrs={'min': 1}),
        }

    def __init__(self, *args, **kwargs):
        self.owner = kwargs.pop('owner', None)
        super().__init__(*args, **kwargs)

    def clean(self):
        cleaned_data = super().clean()
        if not self.owner:
            raise forms.ValidationError('Владелец теста должен быть указан')
        return cleaned_data

    def save(self, commit=True):
        test = super().save(commit=False)
        if self.owner:
            test.owner = self.owner

        # test.test will be assigned from JSON data in the view
        if commit:
            test.save()
        return test