<template>
  <div class="login">
        <div class="log-form">
                <input type="text" v-model="login_data.username" name="username" placeholder="username" class="form-control"/>
                <div v-show="!login_data.username" class="invalid-feedback">username</div>
                <input type="password" v-model="login_data.password" placeholder="password" name="password" class="form-control"/>
                <div v-show="!login_data.password" class="invalid-feedback">password</div>
                <button @click="login" class="btn">Login</button>
                <a class="forgot" href="#/register">Cadastre-se</a>
        </div>
  </div>

</template>

<script>
import axios from 'axios'

export default {
  
    data () { 
        return{
        login_data: {},
        }
    },
    methods: {
       login () {
            console.log(this.login_data);
            const baseURL = 'http://localhost:3000/login';
            axios.post(baseURL, this.login_data)
                .then((result) => {
                    if(!result.data.length){
                        this.register()
                    }else{
                        localStorage.setItem('Login', result.data[0].username)
                        this.search()
                    }
                    console.log(result.data);
            })
        },
        register () {
            this.$router.push('/register')
        },
        search () {
            this.$router.push('/search')
        }
    }
}
</script>

<style scoped>  
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

.limiter {
  width: 100%;
  margin: 0 auto;
}
.log-form {
  width: 40%;
  min-width: 320px;
  max-width: 475px;
  background: #fff;
  position: absolute;
  top: 30%;
  left: 33%;
}

form {
    display: block;
    width: 100%;
    padding: 2em;
}
input {
    display: block;
    margin: auto auto;
    width: 100%;
    margin-bottom: 2em;
    padding: .5em 0;
    border: none;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 1.25em;
    color: #757575;
}
input:focus {
   outline: none
}

.btn {
    display: inline-block;
    background: #42b983;
    border: 0.5px #87dab4;
    padding: .5em 2em;
    color: white;
    margin-right: .5em;
}
.btn:hover {
    background:  #7bd4ac;
}
.forgot {
    color: lighten(#42b983, 10%);
    line-height: .5em;
    position: relative;
    top: 2.5em;
    text-decoration: none;
    font-size: .75em;
    margin:0;
    padding: 0;
    float: right;
}
</style>