const HapiNowAuth = require('@now-ims/hapi-now-auth');

const { JWT_SECRET } = process.env;

exports.plugin = {
  async register(server) {
    await server.register(HapiNowAuth);

    server.auth.strategy('jwt', 'hapi-now-auth', {
      verifyJWT: true,
      keychain: [JWT_SECRET],
      validate: async (request, token) => {
        const { decodedJWT: credentials } = token;
        let isValid = true;
        const artifacts = {};

        const { db, ObjectID } = request.mongo;
        const coll = db.collection('admins');

        /* eslint no-underscore-dangle: ["error", { "allow": ["_id"] }] */
        const user = await coll.findOne({ _id: new ObjectID(credentials._id) });

        if (!user) {
          isValid = false;
          artifacts.error = 'User not found';
        }

        return { isValid, credentials, artifacts };
      },
    });

    server.auth.default('jwt');
  },
  pkg: {
    name: 'jwt',
    version: '1.0.0',
  },
};
