#!/usr/bin/env python
# -*- coding: utf-8 -*-

from django.views.generic.base import TemplateView

from django.views.generic.list import ListView
from django.http.response import HttpResponseRedirect
from django.contrib.auth import logout


from django.core.urlresolvers import reverse
from django.template.backends.django import Template

import requests

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class IndexView(TemplateView):
    '''
    Main page
    '''
    template_name = 'index.html'


class SearchView(TemplateView):
    """
    Search page
    """
    template_name = 'search.html'


class SearchInfoView(TemplateView):
    """
    Search
    """
    template_name = 'search.html'

    def get_context_data(self, **kwargs):
        context = super(SearchInfoView, self).get_context_data(**kwargs)

        # r = requests.get(settings.WSINFO)
        # r = r.json()

        return context
