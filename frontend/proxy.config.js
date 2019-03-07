const proxy = [
  {
    context: '/api',
    target: 'http://localhost',
    pathRewrite: {'^/api' : ''}
  }
];

module.exports = proxy;
