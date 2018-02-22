import Vue from 'vue';
import store from './store';
import router from './router';

import App from './components/App.vue';

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
});
