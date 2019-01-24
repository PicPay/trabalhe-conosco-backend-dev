from django.apps import AppConfig


class PicPayConfig(AppConfig):
    name = 'picpay'

    def ready(self):
        import picpay.signals
