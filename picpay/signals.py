from .models import PicPayUser
from django.db.models.signals import post_save, post_delete
from django.dispatch import receiver

# Signal to add/update/delete PicPayUser into ES (Elastic Search)


@receiver(post_save, sender=PicPayUser)
def index_post(sender, instance, **kwargs):
    instance.indexing()


@receiver(post_delete, sender=PicPayUser)
def remove_index_post(sender, instance, **kwargs):
    instance.remove()
