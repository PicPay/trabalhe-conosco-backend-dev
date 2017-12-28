const routes = require('./routes');

exports.plugin = {
  async register(server) {
    server.route(routes);
  },
  pkg: {
    name: 'auth',
    version: '1.0.0',
  },
};
