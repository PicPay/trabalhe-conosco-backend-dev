from flask import Blueprint, jsonify, request
from flask_jwt_simple import create_jwt


auth = Blueprint("auth", __name__)


@auth.route("/auth/token", methods=["POST"])
def login():
    if not request.is_json:
        return jsonify({"msg": "Faltam parametros"}), 400

    params = request.get_json()
    username = params.get("username", None)
    password = params.get("password", None)

    if not username:
        return jsonify({"msg": "Favor informar o login"}), 400
    if not password:
        return jsonify({"msg": "Favor informar a senha"}), 400

    if username != "valido" or password != "senha":
        return jsonify({"msg": "Login ou senha incorretos"}), 401

    return jsonify({"token": create_jwt(identity=username)}), 200
