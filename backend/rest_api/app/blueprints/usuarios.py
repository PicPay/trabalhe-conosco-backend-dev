import os
from unidecode import unidecode
from flask_jwt_simple import jwt_required
from elasticsearch import Elasticsearch
from flask import Blueprint, jsonify, request


ELASTIC_ENDPOINT = os.getenv("ELASTIC_ENDPOINT", "http://localhost:9200")

usuarios = Blueprint('usuarios', __name__)


@usuarios.route("/usuario", methods=["GET"])
@jwt_required
def get_list_usuario():
    try:
        key = "" if request.args.get("key") is None \
            else request.args.get("key")
        skip = 0 if request.args.get("skip") is None \
            else int(request.args.get("skip"))
        take = 15

        sort = [{
            "priority": {"missing": "_last"}
        }]
        query = {
            "multi_match": {
                "query": unidecode(key).lower(),
                "fields": [
                    "nome",
                    "username"
                ],
                "type": "phrase_prefix"
            }
        }
        es = Elasticsearch([ELASTIC_ENDPOINT])
        result = es.search(index="pessoas",
                           size=take,
                           from_=skip,
                           body={"sort": sort,
                                 "query": query},
                           filter_path=["hits.total",
                                        "hits.hits._id",
                                        "hits.hits._source.*"])

        total = result["hits"]["total"]
        begin = skip+1
        end = skip+take
        header_value = "{}-{}/{}".format(begin, end, total)

        output = []

        if "hits" in result["hits"]:
            for hit in result["hits"]["hits"]:
                rank = 0
                if "priority" in hit["_source"]:
                    rank = hit["_source"]["priority"]
                item = {
                    "id": hit["_id"],
                    "nome": hit["_source"]["nome"],
                    "username": hit["_source"]["username"],
                    "priority": rank
                }
                output.append(item)

        return jsonify(output), 201, {"Content-Range": header_value}
    except:
        return jsonify([])
