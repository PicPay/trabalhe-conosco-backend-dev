<template>
    <section>
        <b-field label="Username"
                 type="username"
                 v-model="username">
            <b-input value="demo" maxlength="30"></b-input>
        </b-field>

        <b-field label="Password">
            <b-input type="password"
                     v-model="password"
                     password-reveal>
            </b-input>
        </b-field>
        <b-field><!-- Label left empty for spacing -->
            <p class="control">
                <button class="button is-primary" v-on:click="auth">
                    Autenticar
                </button>
            </p>
        </b-field>

    </section>
</template>

<script>

    import {login} from '../utils/auth';

    export default {
        name: 'demo',
        data() {
            return {
                username: 'demo',
                password: 'demo',
            };
        },
        methods: {
            auth: function() {
                login(this.username, this.password);
            }
        }
    }
</script>