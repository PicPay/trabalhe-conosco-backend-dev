import os
import redis
from rq import Queue
from notifier import Notifier
from index_manager import IndexManager


ENDPOINT = os.getenv('REDIS_ENDPOINT', 'redis://localhost:6379')
INDEX_NAME = "pessoas"
DOC_TYPE = "_doc"


class Queuer:

    def __init__(self):
        self._redis = redis.from_url(ENDPOINT)
        self._queue = Queue("load_job", connection=self._redis)
        self._queue.delete(delete_jobs=True)

    def enqueue(self, df):
        self._queue.enqueue(process, df)

    def health(self):
        try:
            self._redis.client_getname()
            return True
        except redis.exceptions.ConnectionError:
            return False


def process(df):
    index_mng = IndexManager()
    notifier = Notifier()
    actions = []
    for index, row in df.iterrows():
        action = {
            "_index": INDEX_NAME,
            "_type": DOC_TYPE,
            "_id": row[0],
            "_source": {
                "nome": row[1],
                "username": row[2]
            }
        }

        rank = notifier.get_rank(row[0])
        if rank is not None:
            action["_source"]["priority"] = rank

        actions.append(action)

    index_mng.bulk_load(actions)
