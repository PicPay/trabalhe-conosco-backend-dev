const Boom = require('boom');
const bcrypt = require('bcrypt');
const { createAccessToken } = require('./utils');

const { BCRYPT_SALT_ROUNDS } = process.env;

exports.login = async (request) => {
  const { email, password } = request.payload;
  const { db } = request.mongo;
  const coll = db.collection('admins');

  const user = await coll.findOne({ email });

  if (!user) {
    throw Boom.notFound('User not found');
  }

  if (!bcrypt.compareSync(password, user.password)) {
    throw Boom.unauthorized('Invalid password');
  }

  delete user.password;
  const token = createAccessToken(user);

  return { access_token: token };
};

exports.register = async (request, h) => {
  const { email, password } = request.payload;
  const { db } = request.mongo;
  const coll = db.collection('admins');

  const salt = bcrypt.genSaltSync(parseInt(BCRYPT_SALT_ROUNDS, 10));
  const hash = bcrypt.hashSync(password, salt);

  try {
    await coll.insert({ email, password: hash });
    const user = await coll.findOne({ email }, { password: 0 });
    const token = createAccessToken(user);
    return h.response({ access_token: token }).code(201);
  } catch (e) {
    throw Boom.conflict('User already exists');
  }
};
