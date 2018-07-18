import os
import time
import requests
from queuer import Queuer
from index_manager import IndexManager


ELASTIC_ENDPOINT = os.getenv('ELASTIC_ENDPOINT', 'http://localhost:9200')
REDIS_ENDPOINT = os.getenv('REDIS_ENDPOINT', 'redis://localhost:6379')


def wait():
    while True:
        try:
            if requests.get(ELASTIC_ENDPOINT).status_code == 200 \
                    and IndexManager().health() \
                    and Queuer().health():
                break
        except requests.exceptions.ConnectionError:
            pass
        time.sleep(5)
