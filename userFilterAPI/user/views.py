from django.conf.urls import url
from django.shortcuts import get_object_or_404, render
from django.db.models import Q
from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status
from user.models import User
from user.serializers import UserSerializer
import json

class UserList(APIView):
    def post(self, request):
        json_data = json.loads(request.body) # request.raw_post_data w/ Django < 1.4
        try:
            filter = json_data['filter']
        except KeyError:
            HttpResponseServerError("Malformed data!")
        users = User.objects.filter(Q(nome__contains=filter) | Q(username__contains=filter))
        serializer = UserSerializer(users, many=True)
        return Response(serializer.data)