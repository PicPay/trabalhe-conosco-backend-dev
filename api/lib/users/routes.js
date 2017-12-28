const Joi = require('joi');
const { get } = require('./handlers');

module.exports = [{
  method: 'GET',
  path: '/users',
  handler: get,
  options: {
    validate: {
      query: {
        page: Joi.number().min(1).default(1),
        search: Joi.string(),
      },
    },
    response: {
      schema: Joi.object({
        meta: Joi.object({
          page: Joi.number(),
          total_pages: Joi.number(),
          total_count: Joi.number(),
        }).required(),
        records: Joi.array().items(Joi.object({
          id: Joi.string(),
          name: Joi.string(),
          username: Joi.string(),
        })).required(),
      }),
    },
  },
}];
