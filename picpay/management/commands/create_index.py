# -*- coding: utf-8 -*-
from django.core.management.base import BaseCommand

from picpay.search import PicPayUserIndex


__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class Command(BaseCommand):

    def create_index(self):
        PicPayUserIndex.init()

    def handle(self, *args, **options):
        self.create_index()
