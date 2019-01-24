#!/usr/bin/env python
# -*- coding: utf-8 -*-

from rest_framework import permissions
from rest_framework import status
from rest_framework.response import Response
from rest_framework.views import APIView

from picpay.search import *

from .secrets import *

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class InfoSearchViewSet(APIView):
    """
    title: Basic Info to start the Search

    * description: Return the informations that are necessary to use the service api.v1.search"

    * retrieve: token to start the search
    """
    permission_classes = (permissions.AllowAny,)

    def get(self, request, *args, **kw):

        infs = {}
        if 'data_search' in kw:
            infs = info_search(kw['data_search'])
        else:
            infs = info_search()

        if 'success' in infs:
            for key in list(request.session.keys()):
                del request.session[key]
            request.session.modified = True

            token = token_hex(6)
            request.session[token] = infs

            response = {}
            response['pages'] = infs['pages']
            response['total'] = infs['total']
            response['success'] = infs['success']
            response['token'] = token
            print("token : " + str(response['token']))
        else:
            response = {}
            response['error'] = infs['error']
        return Response(response, status=status.HTTP_200_OK)


class UserSearchViewSet(APIView):
    """
    title: Search by users

    * description: Return the informations about users.

    * retrieve: users (id, username and fullname)
    """

    permission_classes = (permissions.AllowAny,)

    def get(self, request, *args, **kw):
        response = {}
        if 'token' in kw:
            if kw['token'] in request.session:
                if 'data_search' in kw:
                    if not (kw['data_search'] == request.session[kw['token']]['data_search']):
                        response['error'] = 'data_search invalid'
                    else:
                        response = search(data_search=kw['data_search'], info_search=request.session[kw['token']], page=(int(kw['page']) - 1))
                else:
                    if not ('data_search' in kw):
                        if request.session[kw['token']]['data_search'] is not None:
                            response['error'] = 'data_search invalid'
                        else:
                            response = search(info_search=request.session[kw['token']], page=(int(kw['page']) - 1))
            else:
                response['error'] = 'invalid token'
        return Response(response, status=status.HTTP_200_OK)
