import {Injectable} from '@angular/core';

const tokenName = 'id_token';

@Injectable()
export class JwtService {

    getToken(): string {
        return window.localStorage[tokenName];
    }

    saveToken(token: string) {
        window.localStorage[tokenName] = token;
    }

    destroyToken() {
        window.localStorage.removeItem(tokenName);
    }
}
