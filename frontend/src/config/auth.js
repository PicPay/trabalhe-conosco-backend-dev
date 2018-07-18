import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueAuth from '@websanova/vue-auth';
import httpAxios from '@websanova/vue-auth/drivers/http/axios.1.x.js';
import routerModule from '@websanova/vue-auth/drivers/router/vue-router.2.x.js';

import router from '@/router';
import auth_driver from '@/config/auth_drive';

Vue.router = router;

Vue.use(VueAxios, axios);
Vue.axios.defaults.baseURL = process.env.VUE_APP_API
  ? process.env.VUE_APP_API
  : 'api';

Vue.use(VueAuth, {
  tokenDefaultName: 'auth_token',
  tokenStore: ['localStorage'],
  auth: auth_driver,
  http: httpAxios,
  router: routerModule,
  loginData: { url: 'auth/token', redirect: 'home', fetchUser: false },
  logoutData: { redirect: 'login' },
  fetchData: { enabled: false },
  refreshData: { enabled: false }
});
