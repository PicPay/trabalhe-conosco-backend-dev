const KEY_BACKEND_URL = 'backend-url';
const KEY_API_KEY     = 'api-key';

const DEFAULT_BACKEND_URL = 'http://localhost:8081/';
const DEFAULT_API_KEY     = 'Rr7v6ljWLslAGYwitqAvdpfbYPSRR3VHiIKLRrKL8ZM=';

class AppSettings {

  get backendUrl() {
    return (localStorage.getItem(KEY_BACKEND_URL) || DEFAULT_BACKEND_URL);
  }

  set backendUrl(url) {
    if (url && url.trim().length) {
      if (!url.endsWith('/')) {
        url += '/';
      }
      localStorage.setItem(KEY_BACKEND_URL, url);
    }
  }

  get apiKey() {
    return (localStorage.getItem(KEY_API_KEY) || DEFAULT_API_KEY);
  }

  set apiKey(apiKey) {
    if (apiKey && apiKey.trim().length) {
      localStorage.setItem(KEY_API_KEY, apiKey);
    }
  }

}

export default new AppSettings();