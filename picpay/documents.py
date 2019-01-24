#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
from elasticsearch_dsl import DocType, Index
from picpay.models import PicPayUser

from elasticsearch.helpers import bulk
from elasticsearch import Elasticsearch
from . import models

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


picpayuser = Index('users')

picpayuser.settings(
    number_of_shards=1,
    number_of_replicas=0
)


@picpayuser.doc_type
class PicPayUserDocument(DocType):
    class Meta:
        model = PicPayUser

        fields = [
            'id',
            'username',
            'full_name',
        ]

        # To ignore auto updating of Elasticsearch when a model is save
        # or delete
        # ignore_signals = True
        # Don't perform an index refresh after every update (overrides global setting)
        # auto_refresh = False
"""