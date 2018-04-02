import Vue from 'vue';
import VueResource from 'vue-resource';

Vue.use(VueResource);

export default function auth(username, password) {
    return Vue.http.post('/api/getToken', {
        username: username,
        password: password
    })
}