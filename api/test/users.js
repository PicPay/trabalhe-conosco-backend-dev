const { before, describe, it } = exports.lab = require('lab').script();
const { expect } = require('code');
const { internet } = require('faker');
const { resolve, join } = require('path');
const { compose } = require('glue');
const manifest = require('../manifest');

let server;
let authorization;

async function startServer() {
  server = await compose(manifest, {
    relativeTo: join(resolve(), '/lib'),
  });
}

describe('/users', () => {
  const options = {
    method: 'GET',
    url: '/users',
  };

  before(startServer);

  // acquiring access token
  before(async () => {
    const payload = {
      email: internet.email(),
      password: internet.password(),
    };

    // register a new admin
    await server.inject({
      payload,
      method: 'POST',
      url: '/auth/register',
    });

    // acquire access token
    const { result } = await server.inject({
      payload,
      method: 'POST',
      url: '/auth/login',
    });

    authorization = `Bearer ${result.access_token}`;
  });

  it('should return status code 401 when user not autenticated', async () => {
    const res = await server.inject(options);
    expect(res.statusCode).to.be.equal(401);
  });

  it('should return a list of users', async () => {
    const res = await server.inject({
      ...options, headers: { authorization },
    });
    expect(res.statusCode).to.be.equal(200);
    expect(res.result.records).to.be.a.array();
    expect(res.result.meta).to.be.a.object();
  });

  it('should search and return an list of users', async () => {
    const res = await server.inject(Object.assign(options, {
      url: '/users?search=Abraham',
      headers: { authorization },
    }));
    expect(res.statusCode).to.be.equal(200);
    expect(res.result.records).to.be.a.array();
    expect(res.result.records.length).to.be.above(1);
    expect(res.result.records[0].name).to.include('Abraham');
    expect(res.result.meta).to.be.a.object();
  });

  it('should return a paginate list of users', async () => {
    const res = await server.inject(Object.assign(options, {
      url: '/users?page=2',
      headers: { authorization },
    }));
    expect(res.statusCode).to.be.equal(200);
    expect(res.result.records).to.be.a.array();
    expect(res.result.records).to.have.length(15);
    expect(res.result.meta).to.be.a.object();
    expect(res.result.meta.page).to.be.equal(2);
  });
});
