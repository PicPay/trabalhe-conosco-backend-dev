import os
from elasticsearch import Elasticsearch
from elasticsearch import helpers


INDEX_NAME = "pessoas"
ELASTIC_ENDPOINT = os.getenv('ELASTIC_ENDPOINT', 'http://localhost:9200')


class IndexManager:

    def __init__(self):
        self._elastic = Elasticsearch(ELASTIC_ENDPOINT)

    def health(self):
        return self._elastic.cluster.health()["status"] != "red"

    def create(self):
        index_settings = {
            "settings": {
                "index": {
                    "number_of_shards": 1,
                    "number_of_replicas": 0
                }
            },
            "mappings": {
                "_doc": {
                    "properties": {
                        "nome": {
                            "type": "text"
                        },
                        "username": {
                            "type": "text"
                        },
                        "priority": {
                            "type": "integer"
                        }
                    }
                }
            }
        }
        self._elastic.indices.create(index=INDEX_NAME,
                                     ignore=400,
                                     body=index_settings)

    def bulk_load(self, actions):
        helpers.bulk(self._elastic, actions)
