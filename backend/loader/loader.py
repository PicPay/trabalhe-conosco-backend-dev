import os
import re
import csv
import glob
import pandas
from notifier import Notifier
from queuer import Queuer
from index_manager import IndexManager


ELASTIC_BULK_SIZE = int(os.getenv('ELASTIC_BULK_SIZE', 2500))
FILE_NAME = os.getenv('FILE_NAME', 'users.dev.csv')


class Loader:

    def __init__(self):
        self._index_manager = IndexManager()
        self._notifier = Notifier()
        self._queuer = Queuer()
        self.priorities()
        self.bulk_load()

    def bulk_load(self):
        self._index_manager.create()
        df = pandas.read_csv(os.path.join("data", FILE_NAME), header=None)
        total = df.shape[0]
        self._notifier.total(total)
        i = 0
        while i - ELASTIC_BULK_SIZE < total:
            end = i + ELASTIC_BULK_SIZE
            self._queuer.enqueue(df.iloc[i:end])
            i = end

    def priorities(self):
        files = glob.glob(os.path.join("data", "lista_relevancia_*.txt"))
        for file in files:
            file_name = os.path.basename(file)
            rank = re.sub("[^0-9]", "", file_name)
            df = pandas.read_csv(file, header=None)
            for index, row in df.iterrows():
                self._notifier.set_rank(row[0], rank)
