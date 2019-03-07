import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';

import { Observable } from 'rxjs';
import { Page } from '../models/models';

@Injectable()
export class UserService {

  private headers: Headers
  
  constructor(private http: Http) {
    this.headers = new Headers();
    this.headers.append('Content-Type', 'application/json');
  }

  getUserList(): Observable<any> {
    return this.http.get(`http://localhost/api/user/?key=a&page=0&rows=10`).map(res => res.json());
  }

  getUserPage(key, page, size): Observable<Page> {
    return this.http.get(`http://localhost/api/user/?key=${key}&page=${page}&rows=${size}`).map(res => res.json());
  }

}
