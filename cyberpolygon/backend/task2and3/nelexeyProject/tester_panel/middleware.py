from django.http import Http404

class RoleRestrictionMiddleware:
    def __init__(self, get_response):
        self.get_response = get_response

    def __call__(self, request):
        if request.path.startswith('/tester/') and not (
            request.user.is_authenticated and request.user.role in ['tester', 'admin']
        ):
            raise Http404("Page not found")
        return self.get_response(request)
