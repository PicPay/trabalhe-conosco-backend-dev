import os
import pytz
import redis
import requests
from . import delay
from elasticsearch import Elasticsearch
from flask_socketio import emit
from datetime import datetime
from .. import socketio


REDIS_ENDPOINT = os.getenv("REDIS_ENDPOINT", "redis://localhost:6379")
ELASTIC_ENDPOINT = os.getenv('ELASTIC_ENDPOINT', 'http://localhost:9200')
TOTAL = os.getenv("REDIS_TOTAL_KEY", "records_total")


def watch_redis(app):
    delay.wait()
    with app.app_context():
        _redis = redis.from_url(REDIS_ENDPOINT)
        _elastic = Elasticsearch(ELASTIC_ENDPOINT)

        while True:
            try:
                _stats = _elastic.indices.stats(index='pessoas')[
                    '_all']['total']
                _index = _elastic.indices.get(index='pessoas')[
                    'pessoas']['settings']['index']
                data = {
                    "total": _redis.get(TOTAL).decode("utf-8"),
                    "begin": get_utc_date(int(_index['creation_date'])/1000),
                    "processed": _stats['docs']['count']
                }
                loader_status(data)
                socketio.sleep(1)
            except:
                socketio.sleep(5)


def loader_status(data):
    emit(
        "status_update",
        data,
        broadcast=True,
        namespace='/loader'
        )


def get_utc_date(seconds):
    local_zone = pytz.timezone("America/Sao_Paulo")
    naive = datetime.fromtimestamp(seconds)
    local_date = local_zone.localize(naive, is_dst=None)
    utc_date = local_date.astimezone(pytz.utc)
    return "{}Z".format(utc_date.strftime("%Y-%m-%dT%H:%M:%S.%f")[:-3])
