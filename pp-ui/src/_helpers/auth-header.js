export function authHeader() {
    let user = JSON.parse(localStorage.getItem('user'));
    console.log(user);
    if (user && user.token) {
        return { 'Authorization':  localStorage.getItem( "token" ) };
    } else {
        return {};
    }
}