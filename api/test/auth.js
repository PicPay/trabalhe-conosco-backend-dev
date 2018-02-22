/* eslint max-statements-per-line: ["error", { "max": 5 }] */
const { before, describe, it } = exports.lab = require('lab').script();
const { expect } = require('code');
const { internet } = require('faker');
const { resolve, join } = require('path');
const { compose } = require('glue');
const manifest = require('../manifest');

let server;

async function startServer() {
  server = await compose(manifest, {
    relativeTo: join(resolve(), '/lib'),
  });
}

const payload = {
  email: internet.email(),
  password: internet.password(),
};

describe('/auth/register', () => {
  const options = {
    payload,
    method: 'POST',
    url: '/auth/register',
  };

  before(startServer);

  it('should create a new user and return status code 201', async () => {
    const server = await compose(manifest, { relativeTo: join(resolve(), '/lib') });
    const res = await server.inject(options);
    expect(res.statusCode).to.be.equal(201);
    expect(res.result.access_token).to.be.a.string();
  });

  it('should return status code 409 when user already exists', async () => {
    const res = await server.inject(options);
    expect(res.statusCode).to.be.equal(409);
    expect(res.result.message).to.be.equal('User already exists');
  });
});

describe('/auth/login', () => {
  const options = {
    payload,
    method: 'POST',
    url: '/auth/login',
  };

  before(startServer);

  it('should successfully login', async () => {
    const res = await server.inject(options);
    expect(res.statusCode).to.be.equal(200);
    expect(res.result.access_token).to.be.a.string();
  });

  it('should return status code 401 when password is invalid', async () => {
    options.payload.password = internet.password();
    const res = await server.inject(options);
    expect(res.statusCode).to.be.equal(401);
    expect(res.result.message).to.be.equal('Invalid password');
  });

  it('should return status code 404 when user not found', async () => {
    options.payload.email = internet.email();
    const res = await server.inject(options);
    expect(res.statusCode).to.be.equal(404);
    expect(res.result.message).to.be.equal('User not found');
  });
});
