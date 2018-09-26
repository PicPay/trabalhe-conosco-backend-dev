import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import SearchUsers from '@/components/SearchUsers'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/search',
      name: 'SearchUsers',
      component: SearchUsers
    }
  ]
})
