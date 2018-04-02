import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router);

import Home from '../components/Home'
import UsersList from '../components/UsersList'
import Login from '../components/Login'
import Notfound from '../components/Notfound'


export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'homepage',
            component: Home
        },
        {
            path: '*',
            name: 'notfound',
            component: Notfound
        },
        {
            path: '/users',
            name: 'usersList',
            component: UsersList
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
    ]
})