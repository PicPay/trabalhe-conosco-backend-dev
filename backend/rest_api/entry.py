from flask import current_app
from datetime import datetime
from flask_jwt_simple import JWTManager
from app import create_app, socketio, watcher

flask_app = create_app()

jwt = JWTManager(flask_app)

socketio.start_background_task(watcher.watch_redis, flask_app)


@jwt.jwt_data_loader
def add_claims_to_access_token(identity):
    now = datetime.utcnow()
    return {
        "aud": "picpay_audience",
        "exp": now + current_app.config["JWT_EXPIRES"],
        "iat": now,
        "nbf": now,
        "sub": identity
    }


if __name__ == '__main__':
    socketio.run(flask_app)
