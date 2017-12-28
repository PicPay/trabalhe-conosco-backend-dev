const MongoDB = require('hapi-mongodb');

const { MONGO_DB_URL } = process.env;

exports.plugin = {
  async register(server) {
    await server.register({
      plugin: MongoDB,
      options: {
        url: MONGO_DB_URL,
        decorate: true,
      },
    });
  },
  pkg: {
    name: 'db',
    version: '1.0.0',
  },
};
