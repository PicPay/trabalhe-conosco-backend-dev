import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router';
import axios from 'axios'
//import HelloWorld from './components/HelloWorld.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import Search from './components/Search.vue'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

Vue.use(VueRouter);

Vue.prototype.$http = axios

const routes = [
  {path: '/', component: Login},
  {path: '/login', component: Login},
  {path: '/register', component: Register},
  {path: '/search', component: Search, meta: {
    requiresAuth: true
   }
  }
];

const router = new VueRouter({
  routes
})

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router
}).$mount('#app')


const requiresAuth = localStorage.getItem('Login');
if(!requiresAuth) {
  router.push('/login');
} else {
  router.push('/search');
}