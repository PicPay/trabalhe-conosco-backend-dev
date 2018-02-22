<template lang="html">
  <div class="card login">
    <div class="card-content">
      <p class="title">Login</p>

      <div class="notification is-danger" v-show="loginStatus === 'fail'">
        {{loginFailureMessage}}
      </div>

      <form @submit.prevent="login(user)">
        <div class="field">
          <div class="control">
            <input
            class="input"
            type="email"
            placeholder="E-mail"
            v-model="user.email"
            required>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input
            class="input"
            type="password"
            placeholder="Password"
            v-model="user.password"
            required>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <button
            class="button is-primary"
            type="submit"
            :class="{ 'is-loading': loginStatus === 'pending'}">
              Login
            </button>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <router-link class="center" to="register">Not a user? Register</router-link>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      user: {
        email: '',
        password: ''
      }
    }
  },
  methods: mapActions([
    'login'
  ]),
  computed: mapGetters([
    'isLoggedIn',
    'loginStatus',
    'loginFailureMessage'
  ]),
  watch: {
    isLoggedIn(value) {
      if (value) {
        this.$router.push('/dashboard');
      }
    }
  }
}
</script>

<style lang="css">
.login {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 350px;
}

.login button[type="submit"] {
  width: 100%;
}

.login a {
  display: block;
  width: 100%;
  text-align: center;
}
</style>
