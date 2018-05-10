<template>
    <div class="container">
        <nav class="navbar is-fixed-top is-primary">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="#">PicPay Users</a>
                    <div class="navbar-burger burger" data-target="vue-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div id="vue-menu" class="navbar-menu">
                    <div class="navbar-start">
                        <router-link tag='div' to="/" class="navbar-item">Home</router-link>
                        <router-link tag='div' v-show="isLoggedIn()" to="/users" class="navbar-item">Consultar Usuários</router-link>
                        <router-link tag='div' v-show="!isLoggedIn()" to="/login" class="navbar-item">Login</router-link>
                        <a v-show="isLoggedIn()"  v-on:click="handleLogout" class="navbar-item">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import { isLoggedIn, logout } from './utils/auth';
    export default {
        name: 'app',
        methods: {
            handleLogout() {
                logout();
            },
            isLoggedIn() {
                return isLoggedIn();
            },
        },
    }
</script>