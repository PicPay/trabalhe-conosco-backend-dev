# -*- coding: utf-8 -*-


from picpay.settings import PATH_FILE_PRIORITY
from picpay.models import PicPayPriority

from django.core.management.base import BaseCommand
from django.db.transaction import atomic
from datetime import datetime
from tqdm import tqdm

import pytz
import csv
import threading


__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2017'
__version__ = '0.0.1'


class Command(BaseCommand):

    @atomic
    def load_priority(self):

        tz = pytz.timezone('Brazil/East')
        print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

        print("Start loading priority...")

        print(PATH_FILE_PRIORITY)
        with open(PATH_FILE_PRIORITY, 'r') as f:
            p = csv.reader(f)

            p = list(p)
            t = len(p) + 10  # defines priority

            p_picpay = []
            for line in tqdm(p):
                if PicPayPriority.objects.filter(id=line[0]).exists():
                    print("User Priority already setted, id: " + line[0])
                else:
                    picpriority = PicPayPriority()
                    picpriority.id = line[0]
                    picpriority.weight = t
                    t = t - 1
                    p_picpay.append(picpriority)

            t = threading.Thread(target=picpay_priority_bulk_create, args=(p_picpay))
            t.start()
            while t.is_alive():
                pass

        print("End loading priority...")
        print(datetime.utcnow().replace(tzinfo=pytz.UTC).astimezone(tz).strftime('%d/%m/%Y %H:%M:%S'))

    def handle(self, *args, **options):
        self.load_priority()


def picpay_priority_bulk_create(*priority_picpay):
    PicPayPriority.objects.bulk_create(priority_picpay)
