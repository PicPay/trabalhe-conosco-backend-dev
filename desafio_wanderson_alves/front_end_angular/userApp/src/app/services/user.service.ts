import { Observable } from 'rxjs/Observable';
import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

import { User } from './../domain/user';
import 'rxjs/add/operator/catch';

@Injectable()
export class UserService {

  urlBase: string = 'http://localhost:3000/';
  constructor(private http: Http) { }
  users:User[] = [];

  getUsers(page: number, pageSize: number, search: string): Observable<User[]> {
    debugger;
    let  url: string = this.urlBase + 'api/user/' + page + '/' + pageSize + '/' + search;

    return this.http.get(url)
    .map(res => res.json())
    .catch(err => {
       throw new Error(err.message);});
  }

}
