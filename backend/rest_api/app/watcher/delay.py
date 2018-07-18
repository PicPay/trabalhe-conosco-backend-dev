from .. import socketio
from ..health_check import HealthCheck


def wait():
    while True:
        health = HealthCheck()
        if health.elastic() and health.redis():
            break
        socketio.sleep(5)
