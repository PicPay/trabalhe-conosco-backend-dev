import Vue from 'vue';
import VueResource from 'vue-resource';
import {getAccessToken} from "../utils/auth";

Vue.use(VueResource);

export default function getList(query, page) {
    const params = [
        `query=${query}`,
        `page=${page}`
    ].join('&');

    return Vue.http.get(`/api/users?${params}`, {
        headers: {
            Authorization: `Bearer ${getAccessToken()}`
        }
    })
}