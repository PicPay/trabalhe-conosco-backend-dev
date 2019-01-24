#!/usr/bin/env python
# -*- coding: utf-8 -*-

from django.conf.urls import url, include
from django.contrib import admin
from picpay import settings
from rest_framework import routers
from api import users
from picpay.views import IndexView, SearchView, SearchInfoView

# Routers provide an easy way of automatically determining the URL conf.
router = routers.DefaultRouter()

from rest_framework_swagger.views import get_swagger_view
# from rest_framework.documentation import include_docs_urls

# from django.conf import settings
from django.conf.urls.static import static

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


schema_view = get_swagger_view(title='Search API')


urlpatterns = [

    # url(r'^api/v1/', include(router.urls)),
    # url(r'^api/v1/auth/', include('rest_framework.urls', namespace='rest_framework')),
    # url(r'^api/v1/schema/$', schema_view(), name="api.v1.schema.view"),
    # url(r'^api/v1/schema/', include_docs_urls(title='Search API', public=True), name="api.v1.schema.view"),
    url(r'^api/v1/users/(?P<token>[\w ]+)/(?P<page>\d+)/$', users.UserSearchViewSet.as_view(), name="api.v1.search"),
    url(r'^api/v1/users/(?P<data_search>[\w ]+)/(?P<token>[\w ]+)/(?P<page>\d+)/$', users.UserSearchViewSet.as_view(), name="api.v1.search"),
    url(r'^api/v1/info/$', users.InfoSearchViewSet.as_view(), name="api.v1.info.search"),
    url(r'^api/v1/info/(?P<data_search>[\w ]+)/$', users.InfoSearchViewSet.as_view(), name="api.v1.info.search"),
    url(r'^admin/', admin.site.urls),
    url(r'^search/', SearchView.as_view(), name="search.view"),
    url(r'^', IndexView.as_view(), name="search.api"),
] + static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)


if settings.DEBUG:
    import debug_toolbar
    urlpatterns = [
        url(r'^__debug__/', include(debug_toolbar.urls)),
    ] + urlpatterns
