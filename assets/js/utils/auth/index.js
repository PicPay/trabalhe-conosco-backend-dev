import auth from '../../api/auth';
const ACCESS_TOKEN_KEY = 'access_token';

export function login(username, password) {
    auth(username, password).then(result => {
        setAccessToken(result.body.token);
        window.location.href = '/';
    }).catch(error => {
        alert(error);
    })
}

export function logout() {
    clearAccessToken();
    window.location.href = '/';
}

export function requireAuth(to, from, next) {
    if (!isLoggedIn()) {
        next({
            path: '/',
            query: { redirect: to.fullPath }
        });
    } else {
        next();
    }
}

export function getAccessToken() {
    return localStorage.getItem(ACCESS_TOKEN_KEY);
}

function clearAccessToken() {
    localStorage.removeItem(ACCESS_TOKEN_KEY);
}

export function setAccessToken(accessToken) {
    localStorage.setItem(ACCESS_TOKEN_KEY, accessToken);
}

export function isLoggedIn() {
    const token = getAccessToken();
    return !!token;
}
