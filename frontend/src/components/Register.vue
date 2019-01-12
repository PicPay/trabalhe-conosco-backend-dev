<template>
    <div class="login">
        <div class="log-form">
            <input type="text" v-model="data_reg.username" title="username" placeholder="username"/>
            <input type="password" v-model="data_reg.password" title="password" placeholder="password"/>
            <input type="password" v-model="confirm_password" title="confirm_password" placeholder="confirm password"/>
            <button @click="register" class="btn">Cadastrar</button>
            <a class="forgot" href="#/login">Já possui cadastro?</a>
            <div>
                <br>
                <a class="message" v-model="message">{{message}}</a>
            </div>
        </div>
    </div>

</template>
<script>
import axios from 'axios'

export default {
    data () {
        return {
            data_reg: {},
            confirm_password: '',
            message: ''
        }
    },
    methods: {
        register () {
            if(this.data_reg.password != this.confirm_password){
                this.message = 'Confirme sua senha!' 
            }
            const baseURL = 'http://localhost:3000/register';
            axios.post(baseURL, this.data_reg)
                .then((result) => {
                console.log(result);

                    if(result.status == 200){
                        localStorage.setItem('Login', result.data[0].username)
                        this.$router.push('/search')
                    }
                    if(result.status == 204){
                        this.message = 'Esse usuário já existe!'
                    }
                
            })
            

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
.message {
    color: #42b983 !important;
    font-size: .75em;
    font: times;
}
</style>