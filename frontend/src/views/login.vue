<template>
  <div class="section">
    <div class="columns">
      <div class="column"></div>
      <div class="column is-5">
        <div class="tile box">
          <form @submit.prevent="logOn">
            <formly-form :form="loginForm.form"
                         :model="loginForm.model"
                         :fields="loginForm.fields"
                         tag="section"></formly-form>
            <div class="notification is-danger"
                 v-if="loginForm.error">
              {{loginForm.error}}
            </div>
            <div class="columns">
              <div class="column has-text-centered">
                <button class="button is-primary"
                        type="submit">
                  <b-icon icon="sign-in" />
                  <span>LogIn</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="column"></div>
    </div>
  </div>
</template>

<script>
import { login } from '@/forms/login'

export default {
  name: 'login',
  data() {
    return {
      loginForm: {
        error: '',
        form: {},
        model: {
          login: '',
          password: ''
        },
        fields: login
      }
    }
  },
  methods: {
    logOn() {
      let self = this
      if (self.loginForm.form.$valid) {
        self.loginForm.error = ''
        var redirect = self.$auth.redirect()

        self.$auth
          .login({
            data: {
              username: self.loginForm.model.login,
              password: self.loginForm.model.password
            }, // Axios
            rememberMe: true,
            redirect: { name: redirect ? redirect.from.name : 'home' }
          })
          .then()
          .catch(() => {
            self.loginForm.error = 'Usuário ou senha inválidos!'
          })
      }
    }
  }
}
</script>

<style lang="scss" >
form {
  width: 100%;
  > div {
    margin-top: 15px;
  }
  > div.columns {
    margin-top: 15px;
  }
}
</style>
