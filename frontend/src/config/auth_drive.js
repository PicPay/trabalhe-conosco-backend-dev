export default {
  request: function(req, token) {
    this.options.http._setHeaders.call(this, req, {
      Authorization: 'Bearer ' + token
    })
  },
  response: function(res) {
    if (
      res.status >= 200 &&
      res.status < 300 &&
      res.request.responseURL.includes('auth/token')
    ) {
      return res.data['token']
    }
  }
}
