#!/usr/bin/env python
# -*- coding: utf-8 -*-


from django.db import models
from .search import PicPayUserIndex

import uuid


__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class PicPayUser(models.Model):
    """
    Class that represents users provided by PicPay
    """
    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=True)
    username = models.CharField(max_length=100, verbose_name="Username", blank=False,)
    full_name = models.CharField(max_length=150, verbose_name="Full Name", blank=False,)

    def indexing(self):
        obj = PicPayUserIndex(
            meta={'id': self.id},
            username=self.username,
            full_name=self.full_name,
        )
        obj.save()
        return obj.to_dict(include_meta=True)

    def remove(self):
        obj = PicPayUserIndex(
            meta={'id': self.id},
            username=self.username,
            full_name=self.full_name,
        )
        obj.delete()
        return obj.to_dict(include_meta=True)


class PicPayPriority(models.Model):
    """
    Class that represents the priority users in the search
    TODO: link with PicPayUser
    """
    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=True)
    weight = models.IntegerField(default=1)
