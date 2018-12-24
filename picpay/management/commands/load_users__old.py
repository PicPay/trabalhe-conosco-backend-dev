# -*- coding: utf-8 -*-
from django.core.management.base import BaseCommand
from picpay.settings import PATH_FILE, LIMIT_BULK_CREATE, THREAD_PARALLEL_BULK
from picpay.models import PicPayUser

from django.db.transaction import atomic
from datetime import datetime
import pytz
import csv


import threading
from tqdm import tqdm

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class Command(BaseCommand):

    @atomic
    def populate_db(self):

        jobs = []
        jobs_count = 1
        total_jobs_count = 1
        users_len = 0
        if LIMIT_BULK_CREATE is None:
            print("Please, set the value of users in settings.py for LIMIT_BULK_CREATE")
        else:
            print("The data loading was started.")
            tz = pytz.timezone('Brazil/East')
            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

            total = 0
            with open(PATH_FILE, 'r') as f:
                users = csv.reader(f)
                users = list(users)

            users_len = int((users.__len__() / THREAD_PARALLEL_BULK))

            users = chunks(users, users_len)

            for l in list(users):

                t = threading.Thread(target=list_bulk_create, args=(l))
                jobs.append(t)
                jobs_count = jobs_count + 1
                total_jobs_count = total_jobs_count + 1
                if jobs_count >= THREAD_PARALLEL_BULK:
                    for j in jobs:
                        j.start()
                    for j in jobs:
                        j.join()
                        jobs_count = 0

            # if not (total_jobs_count == list(users).__len__()):
            #    t = threading.Thread(target=list_bulk_create, args=(list(users)[-1]))
            #    t.start()
            #    t.join()
            """
            for line in tqdm(users):
                break
                if PicPayUser.objects.filter(id=line[0]).exists():
                    print("User already registered, username: " + line[2])
                else:
                    picpayuser = PicPayUser()
                    picpayuser.id = line[0]
                    picpayuser.full_name = line[1]
                    picpayuser.username = line[2]

                    users_picpay.append(picpayuser)
                    total = total + 1
                    n = n + 1

                    if n > LIMIT_BULK_CREATE:
                        jobs_count = jobs_count + 1

                        t = threading.Thread(target=picpay_bulk_create, args=(users_picpay))
                        jobs.append(t)
                        # while t.is_alive():
                        #    pass
                        users_picpay = []
                        n = 0

                        if jobs_count > THREAD_PARALLEL_BULK:
                            for j in jobs:
                                j.start()

                            for j in jobs:
                                j.join()

            """
            # if n > 0:
            #    t = threading.Thread(target=picpay_bulk_create, args=(users_picpay))
            #    t.start()
            #    while t.is_alive():
            #        pass

            print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))
            print("The data loading was completed: " + str(total) + " users.")

    @atomic
    def handle(self, *args, **options):
        self.populate_db()


def chunks(l, n):
    for i in range(0, len(l), n):
        yield l[i:i + n]


@atomic
def list_bulk_create(*users):
    users = list(users)
    users_picpay = []
    n = 0

    for line in tqdm(users):
        if PicPayUser.objects.filter(id=line[0]).exists():
            print("User already registered, username: " + line[2])
        else:
            picpayuser = PicPayUser()
            picpayuser.id = line[0]
            picpayuser.full_name = line[1]
            picpayuser.username = line[2]

            users_picpay.append(picpayuser)
            n = n + 1

            if n > LIMIT_BULK_CREATE:

                t = threading.Thread(target=picpay_bulk_create, args=(users_picpay))
                t.start()
                while t.is_alive():
                    pass
                users_picpay = []
                n = 0


@atomic
def picpay_bulk_create(*users_picpay):
    PicPayUser.objects.bulk_create(users_picpay)
