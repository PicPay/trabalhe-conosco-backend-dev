# -*- coding: utf-8 -*-
from django.core.management.base import BaseCommand
from picpay.settings import PATH_FILE, LIMIT_BULK_CREATE, CHECK_USER_DB, LIMIT_BULK_CREATE_BATCH
from django.db.transaction import atomic
from datetime import datetime
from django.db import connection
from contextlib import closing
from tqdm import tqdm
import pandas as pd
import threading
import gc
import pytz

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class Command(BaseCommand):

    @atomic
    def populate_db(self):

        if LIMIT_BULK_CREATE is None or LIMIT_BULK_CREATE_BATCH is None:
            print("Please, set the value of users in settings.py for LIMIT_BULK_CREATE or LIMIT_BULK_CREATE_BATCH")
        else:
            print("The data loading was started.")
            tz = pytz.timezone('Brazil/East')
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

            n = 0
            total = 0
            # with open(PATH_FILE, 'r') as f:
            # users = csv.reader(f)
            # users = list(users)

            df = pd.read_csv(PATH_FILE, sep=',', header=None, chunksize=LIMIT_BULK_CREATE, iterator=True)  # 475186)
            users_picpay = []

            for i, d in enumerate(df, 1):
                for index, row in tqdm(d.iterrows()):
                    if CHECK_USER_DB:
                        pass
                        # if PicPayUser.objects.filter(id=row[0]).exists():
                        #     print("User already registered, username: " + row[2])
                    else:

                        users_picpay.extend([str(row[0]).replace("-", ""), str(row[2]), str(row[1])])
                        total = total + 1
                        n = n + 1

                        if n >= LIMIT_BULK_CREATE_BATCH:
                            t = threading.Thread(target=picpay_batch_insert, args=(users_picpay))
                            t.start()
                            while t.is_alive():
                                pass
                            users_picpay = []
                            n = 0

            if n > 0:
                t = threading.Thread(target=picpay_batch_insert, args=(users_picpay))
                t.start()
                while t.is_alive():
                    pass
                users_picpay = []
                n = 0

            # free memory
            gc.collect()
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))
            print("The data loading was completed: " + str(total) + " users.")

    def handle(self, *args, **options):
        self.populate_db()


def picpay_batch_insert(*users_picpay):

    sql = 'INSERT INTO picpay_picpayuser (id, username, full_name) VALUES {}'.format(
        ', '.join(['(%s, %s, %s)'] * int(users_picpay.__len__() / 3)),
    )

    with closing(connection.cursor()) as cursor:
        cursor.execute(sql, users_picpay)
