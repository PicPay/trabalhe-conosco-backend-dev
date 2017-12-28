const { compose } = require('glue');
const { join } = require('path');
const manifest = require('./manifest');

(async () => {
  try {
    const server = await compose(manifest, { relativeTo: join(__dirname, 'lib') });
    await server.start();
    console.log('[api] running at:', server.info.uri);
  } catch (e) {
    console.error(e);
    process.exit(1);
  }
})();
