#!/usr/bin/env python
# -*- coding: utf-8 -*-

from django.contrib import admin
from picpay.models import PicPayUser, PicPayPriority
from django.contrib.admin.options import ModelAdmin

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class PicPayUserAdmin(ModelAdmin):
    list_display = ('id', 'username', 'full_name')
    search_fields = ('id', 'username', 'full_name')


class PicPayPriorityUserAdmin(ModelAdmin):
    list_display = ('id', 'weight')
    search_fields = ('id', 'weight')


admin.site.register(PicPayUser, PicPayUserAdmin)
admin.site.register(PicPayPriority, PicPayPriorityUserAdmin)
