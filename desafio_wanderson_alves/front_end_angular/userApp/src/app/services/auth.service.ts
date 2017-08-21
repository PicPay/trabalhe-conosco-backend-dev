import { Injectable, EventEmitter } from '@angular/core';
import {Router} from '@angular/router';
// Importar objetos de la librería http
import { Http, Response, RequestOptions, Headers } from '@angular/http';
// Importar la clase Observable desde la librería rxjs
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';

import { User } from './../domain/user';
import { ResponseServer } from './../domain/response-server';

@Injectable()
export class AuthService {
  private userValid: boolean = false;
  autUser = new EventEmitter<boolean>();
  urlBase: string = 'http://localhost:3000/';

  constructor(private router: Router, private http: Http) { }

  login(user: User) {

    let body = JSON.stringify(user);
    let headers = new Headers({ 'Content-Type': 'application/json' });
    let options = new RequestOptions({ headers: headers });

      this.http
      .post(`${this.urlBase}api/login`, body, options)
      .map(res => res.json()).subscribe( (resp: ResponseServer) => this.userLoggedIn(resp),
      (error: ResponseServer) => this.userLoggedIn(error));
  }

  authenticatedUser(): boolean {
    return this.userValid;
  }

  userLoggedIn(resp: ResponseServer) {
    if (resp.token !== '' && resp.token !== undefined) {
      this.userValid = true;
      this.autUser.emit(true);
      this.router.navigate(['home']);
    }else {
      this.autUser.emit(false);
      this.userValid = false;
    }
  }
}
