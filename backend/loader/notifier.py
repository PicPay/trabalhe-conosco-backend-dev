import os
from datetime import datetime
import redis

TOTAL = os.getenv('REDIS_TOTAL_KEY', 'records_total')
ENDPOINT = os.getenv('REDIS_ENDPOINT', 'redis://localhost:6379')


class Notifier:

    def __init__(self):
        self._redis = redis.from_url(ENDPOINT)

    def total(self, count):
        self._redis.set(TOTAL, count)

    def set_rank(self, id, rank):
        self._redis.set(id, rank)

    def get_rank(self, id):
        try:
            return int(self._redis.get(id).decode("utf-8"))
        except:
            return None
