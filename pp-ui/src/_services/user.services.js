import axios from "axios";
import base64 from "base-64";
import utf8 from "utf8";

import config from 'config';
import { authHeader } from '../_helpers';

export const userService = {
    login,
    logout,
    getAll
};

function login(username, password) {
     console.log('${config.apiUrl}');
     let url =  'http://localhost:7700/api/login';
     var headers = {
          headers: { 'Content-Type': 'text/plain'}
     }
     var data = { 'username': username,
                  'password': password
    };
     return axios.post(url,data,headers)
        .then(user => {
        localStorage.setItem('user', JSON.stringify(user));
        return user;
    });
}

function logout() {
    localStorage.removeItem( "token" )
    localStorage.removeItem('user');
}

function getAll() {
    let URL = 'http://localhost:7700/api/user/getAll';
    var config = {
          headers: {'Authorization':  localStorage.getItem( "token" )}
        };

    return axios.get(URL,config).then( users => {
            localStorage.setItem('users', JSON.stringify(users));
        return users;
    });
}

function handleResponse(response) {
    return response.text().then(text => {
            const data = text && JSON.parse(text);
        if (!response.ok) {
            if (response.status === 401) {
                logout();
                location.reload(true);
            }
            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }
        return data;
    });
}
