import Vue from 'vue';
import VueRouter from 'vue-router'
import store from './store';

import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';
import Browser from './components/Browser.vue';
import Search from './components/Search.vue';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [{
    path: '/',
    redirect: '/dashboard'
  }, {
    path: '/login',
    component: Login
  }, {
    path: '/register',
    component: Register
  }, {
    path: '/dashboard',
    redirect: '/dashboard/browser',
    component: Dashboard,
    children: [{
      name: 'browser',
      path: 'browser',
      component: Browser,
      meta: { isLoggedIn: true }
    }, {
      name: 'search',
      path: 'search',
      component: Search,
      meta: { isLoggedIn: true }
    }],
  }]
});

router.beforeEach((to, from, next) => {
  if (to.meta.isLoggedIn && !store.state.isLoggedIn) {
    return next('/login');
  };

  next();
});

export default router;
