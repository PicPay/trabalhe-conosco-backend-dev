import { AuthenticationService } from './authentication.service';
import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';

import { User } from '../models/user';

@Injectable()
export class UserService {

    constructor(private http: HttpClient, public service: AuthenticationService) { }

    getAll(page, search) {
        let params = new HttpParams().set('page', page)
                                        .set('search', search);
        console.log(search);
        return this.http.get<User[]>(`${this.service.endpoint}users`, { params: params },);
    }

    register(user: User) {
        return this.http.post(`${this.service.endpoint}register`, user);
    }
}
