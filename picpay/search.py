#!/usr/bin/env python
# -*- coding: utf-8 -*-

from elasticsearch_dsl.connections import connections
from elasticsearch_dsl import DocType, Text, Search
from elasticsearch_dsl import query
from picpay import models

import timeit

from math import ceil
from elasticsearch_dsl.response.hit import Hit


__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


connections.create_connection()


class PicPayUserIndex(DocType):
    id = Text()
    username = Text()
    full_name = Text()

    class Meta:
        index = 'pcusers-index'


def info_search(data_search=None):
    """
    Create dictionary of priorities for users based on search _score
    Calculate the number of pages for the search

    return info_search = [priorities dict, max_score float, pages int, total float] or {'error': 'No user found for.' + data_search}
    """

    info_search = {}
    info_search['data_search'] = data_search
    if data_search is None:
        data_search = '*'

    # dict to retrieve weight
    priorities = {}

    s = Search(index='pcusers-index').query('query_string',
                                            query=data_search + '*', fields=['username', 'full_name'],
                                            default_operator="or")[0:1]
    response = s.execute()
    response = response.to_dict()

    # basic informations
    if not (response['hits']['max_score'] is None):
        max_score = float(response['hits']['max_score'])
    else:
        max_score = 0

    if not (int(response['hits']['total']) == 0):
        # pagination
        pages = ceil(int(int(response['hits']['total']) / 15))
        total = int(response['hits']['total'])

        type_index = response['hits']['hits'][0]['_type'] + '#'
        if type_index is None:
            type_index = 'pic_pay_user_index#'

        # poputate dict
        pc_priority = models.PicPayPriority.objects.all().order_by('-weight')
        for p in pc_priority:
            uid = type_index + str(p.id)
            priorities[uid] = float(p.weight) + max_score

        # test script
        # priorities['pic_pay_user_index#529b540e-41ad-4bb2-b3f7-331d1d5cca64'] = float(200) + max_score
        # priorities['pic_pay_user_index#348187c3-8424-4d24-87b0-9a5b83c8bdc8'] = float(190) + max_score
        # priorities['pic_pay_user_index#51d095f5-757e-4077-a03d-9f5441f397f4'] = float(180) + max_score

        info_search['priorities'] = priorities
        info_search['max_score'] = round(ceil(max_score), 4)
        if pages == 0:
            pages = 1
        info_search['pages'] = pages
        info_search['total'] = total

        info_search['success'] = 'The search found ' + str(total) + ' user(s) in ' + str(response['took']) + ' milliseconds'
        return info_search
    else:
        response = {}
        response['error'] = 'No user found for: ' + data_search
        return response


def search(data_search='*', info_search=None, page=0, limit=15):
    try:
        if not (info_search is None):
            priorities = info_search['priorities']
            max_score = info_search['max_score']
            # create query
            q = query.Q(
                'function_score',
                query=query.Q('query_string', query=data_search + '*',
                              fields=['username', 'full_name'], default_operator="or",),
                functions=[
                    query.SF('script_score', script={
                        "lang": "painless",
                        'params': {'priorities': priorities},
                        'inline': "def priority = params.priorities.get(doc['_uid'].value); if (priority == null) { return _score; } return priority;",
                    })
                ],
                max_boost=float(models.PicPayPriority.objects.all().order_by('-weight').first().weight) + max_score,
                score_mode="max",
                boost_mode="replace",
                min_score=0.1
            )
            s = Search(index='pcusers-index').query(q)[int(limit * page):int((limit * (page + 1) - 1) + 1)]
            response = s.execute()
            # create response users
            users = []
            for hit in response['hits']['hits']:
                user = {}
                user['id'] = hit['_id']
                user['username'] = hit['_source']['username']
                user['full_name'] = hit['_source']['full_name']
                users.append(user)

                page = page + 1

            return users
        else:
            response = {}
            response['error'] = 'no-info-search-setted'
            return response
    except Exception as e:
        response = {}
        response['error'] = 'page invalid or max window exceeded'
        return response
    # return json.dumps(response.to_dict(), ensure_ascii=False)
