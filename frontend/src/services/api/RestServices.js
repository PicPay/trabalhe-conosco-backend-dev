import axios from 'axios';

const BASE_URL = 'http://localhost:8080';

export {doLogin, signup, search, setTokenHeader, logout};

function doLogin(credentials) {
    const url = BASE_URL + '/auth';
    return axios.post(url, credentials);
}

function signup(credentials) {
    const url = BASE_URL + '/signup';
    return axios.post(url, credentials);
}

function search(keyword) {
    const url = BASE_URL + '/users/search';
    return axios.get(url, { params: keyword });
}

function setTokenHeader(token){
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
}

function logout() {
    axios.defaults.headers.common['Authorization'] = undefined;

    localStorage.removeItem("jwtToken");
    localStorage.removeItem("username");
}

axios.interceptors.response.use(undefined, function (error) {
    if (error.response.data.status === 401 && error.response.data.path !== '/auth') {
        logout();
    }

    throw error;
});