import Vue from 'vue'
import Router from 'vue-router'

import Shell from '@/views/_shell'
import Home from '@/views/home'
import Login from '@/views/login'

Vue.use(Router)

const routes = [
  {
    path: '/',
    component: Shell,
    meta: { auth: true },
    children: [
      {
        path: '',
        name: 'home',
        component: Home
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: { auth: false }
  },
  {
    path: '*',
    redirect: '/'
  }
]

export default new Router({
  mode: 'history',
  routes: routes
})
