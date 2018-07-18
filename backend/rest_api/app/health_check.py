import os
import redis
import requests
from elasticsearch import Elasticsearch


ELASTIC_ENDPOINT = os.getenv('ELASTIC_ENDPOINT', 'http://localhost:9200')
REDIS_ENDPOINT = os.getenv('REDIS_ENDPOINT', 'redis://localhost:6379')


class HealthCheck():

    def __init__(self):
        self._redis = redis.from_url(REDIS_ENDPOINT)
        self._elastic = Elasticsearch(ELASTIC_ENDPOINT)

    def redis(self):
        try:
            self._redis.client_getname()
            return True
        except redis.exceptions.ConnectionError:
            return False

    def elastic(self):
        try:
            if requests.get(ELASTIC_ENDPOINT).status_code == 200:
                return self._elastic.cluster.health()["status"] != "red"
            return True
        except requests.exceptions.ConnectionError:
            return False
