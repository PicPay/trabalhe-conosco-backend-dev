# -*- coding: utf-8 -*-
from django.core.management.base import BaseCommand
from picpay.settings import THREAD_PARALLEL_BULK, MAX_CHUNK_BYTES, CHUNK_SIZE

from django.db.transaction import atomic
from datetime import datetime
from picpay.search import PicPayUserIndex

from elasticsearch.helpers import parallel_bulk
from elasticsearch import Elasticsearch
from picpay import models


from tqdm import tqdm
import pytz

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class Command(BaseCommand):

    """
    http://172.17.8:9200/pcusers-index/_search?pretty=true&q=*:*
    curl -XDELETE http://robertomorati.com:9200/pcusers-index/
        curl -XDELETE 'http://robertomorati.com:9200/pcusers-index/_query' -d '{
            "query" : {
                "match_all" : {}
            }
        }'
    """
    @atomic
    def bulk_indexing(self):

        if THREAD_PARALLEL_BULK is None:
            print("Please, set the value for THREAD_PARALLEL_BULK")
        else:
            tz = pytz.timezone('Brazil/East')
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

            PicPayUserIndex.init()
            es = Elasticsearch()
            users = models.PicPayUser.objects.all()

            print("Start indexing data...")

            # bulk(client=es, actions=(b.indexing() for b in tqdm(users.iterator(), total=users.count())))
            for success, info in parallel_bulk(client=es, actions=(b.indexing() for b in tqdm(users.iterator(), total=users.count())), thread_count=THREAD_PARALLEL_BULK, chunk_size=CHUNK_SIZE, max_chunk_bytes=MAX_CHUNK_BYTES):
                if not success:
                    print("Fail: ".format(info))
            print("End indexing data...")
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

    def handle(self, *args, **options):
        self.bulk_indexing()
