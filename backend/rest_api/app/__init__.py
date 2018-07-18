from flask import Flask
from datetime import timedelta
from flask_socketio import SocketIO
from flask_cors import CORS

from .blueprints.auth import auth
from .blueprints.usuarios import usuarios

socketio = SocketIO()


def create_app():
    app = Flask(__name__)

    cors = CORS(app,
                resources={r"/*": {"origins": "*"}},
                expose_headers=['Origin',
                                'Content-Type',
                                'Accept',
                                'Authorization',
                                'Content-Range',
                                'X-Request-With'])

    app.config["JWT_SECRET_KEY"] = \
        "dd3c964d049cf55dc443f363f399110349f9ad604f9d3f0fd6f32a1058700c3a"
    app.config["JWT_EXPIRES"] = timedelta(hours=8)
    app.config["JWT_DECODE_AUDIENCE"] = "picpay_audience"

    app.register_blueprint(auth)
    app.register_blueprint(usuarios)

    socketio.init_app(app)
    return app
