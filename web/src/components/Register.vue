<template lang="html">
  <div class="card register">
    <div class="card-content">
      <p class="title">Register</p>

      <div class="notification is-danger" v-show="registerStatus === 'fail'">
        {{registerFailureMessage}}
      </div>

      <form @submit.prevent="register(user)">
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
            pattern=".{5,30}"
            title="6 to 30 characters"
            placeholder="Password"
            v-model="user.password"
            required>
            <span class="help">6 to 30 characters</span>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <button
            class="button is-primary"
            type="submit"
            :class="{ 'is-loading': registerStatus === 'pending'}">
              Register
            </button>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <router-link class="center" to="login">Already a user? Login</router-link>
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
    'register'
  ]),
  computed: mapGetters([
    'isLoggedIn',
    'registerStatus',
    'registerFailureMessage'
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
.register {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 350px;
}

.register button[type="submit"] {
  width: 100%;
}

.register a {
  display: block;
  width: 100%;
  text-align: center;
}
</style>
