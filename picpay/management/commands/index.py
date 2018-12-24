# -*- coding: utf-8 -*-
from django.core.management.base import BaseCommand
from picpay.settings import THREAD_PARALLEL_BULK_ES, MAX_CHUNK_BYTES, CHUNK_SIZE

from django.db.transaction import atomic
from datetime import datetime
# from picpay.search import PicPayUserIndex

from elasticsearch.helpers import parallel_bulk
from elasticsearch import Elasticsearch
from picpay import models

from tqdm import tqdm
import pytz
import gc

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class Command(BaseCommand):

    """
    http://172.17.8:9200/pcusers-index/_search?pretty=true&q=*:*
    curl -XDELETE http://192.168.0.122:9200/pcusers-index/
        curl -XDELETE 'http://IP:9200/pcusers-index/_query' -d '{
            "query" : {
                "match_all" : {}
            }
        }'
    """

    @atomic
    def bulk_indexing(self):
        if THREAD_PARALLEL_BULK_ES is None:
            print("Please, set the value for THREAD_PARALLEL_BULK_ES")
        else:
            tz = pytz.timezone('Brazil/East')
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

            # PicPayUserIndex.init()

            es = Elasticsearch(hosts='elasticsearch:9200')

            users = models.PicPayUser.objects.all()
            print("Start indexing users...")

            bulk_users = []
            for b in tqdm(users.iterator(), total=users.count()):
                bulk_users.append(b.indexing(dict=True))
                if (len(bulk_users) >= CHUNK_SIZE):
                    bulk_insert_users(es, bulk_users)
                    bulk_users = []

            if len(bulk_users) > 0:
                bulk_insert_users(es, bulk_users)

            print("End indexing users...")
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

            del es
            # free memory
            gc.collect()

    def handle(self, *args, **options):
        self.bulk_indexing()


def bulk_insert_users(es, bulk_users):
    for success, info in parallel_bulk(client=es, actions=bulk_users, thread_count=THREAD_PARALLEL_BULK_ES, chunk_size=CHUNK_SIZE, max_chunk_bytes=MAX_CHUNK_BYTES):
        if not success:
            print("Fail: ".format(info))
