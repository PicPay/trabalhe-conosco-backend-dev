const Joi = require('joi');
const { login, register } = require('./handlers');

module.exports = [{
  method: 'POST',
  path: '/auth/login',
  handler: login,
  options: {
    auth: false,
    validate: {
      payload: Joi.object().keys({
        email: Joi.string().email().required(),
        password: Joi.string().required(),
      }),
    },
    response: {
      schema: Joi.object({
        access_token: Joi.string().required(),
      }),
    },
  },
}, {
  method: 'POST',
  path: '/auth/register',
  handler: register,
  options: {
    auth: false,
    validate: {
      payload: Joi.object().keys({
        email: Joi.string().email().required(),
        password: Joi.string().min(6).max(30).required(),
      }),
    },
    response: {
      schema: Joi.object({
        access_token: Joi.string().required(),
      }),
    },
  },
}];
