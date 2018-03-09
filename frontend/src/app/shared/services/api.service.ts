import {Injectable} from '@angular/core';
import {environment} from '../../../environments/environment';
import {HttpClient, HttpErrorResponse, HttpHeaders, HttpParams} from '@angular/common/http';

import {catchError} from 'rxjs/operators';
import {ErrorObservable} from 'rxjs/observable/ErrorObservable';
import {Observable} from 'rxjs/Observable';
import {UserAuth} from '../models/user-auth';

@Injectable()
export class ApiService {

  constructor(private http: HttpClient) {
  }

  private formatErrors(error: HttpErrorResponse) {
    return new ErrorObservable(error.error);
  }

  get(path: string, params: HttpParams = new HttpParams()): Observable<any> {
    return this.http.get(`${environment.api_url}${path}`, {params: params})
      .pipe(catchError(this.formatErrors));
  }

  put(path: string, body: Object = {}): Observable<any> {
    return this.http.put(`${environment.api_url}${path}`, JSON.stringify(body))
      .pipe(catchError(this.formatErrors));
  }

  post(path: string, body: Object = {}): Observable<any> {
    return this.http.post(`${environment.api_url}${path}`, JSON.stringify(body))
      .pipe(catchError(this.formatErrors));
  }

  delete(path): Observable<any> {
    return this.http.delete(`${environment.api_url}${path}`)
      .pipe(catchError(this.formatErrors));
  }

  signin(user: UserAuth) {
    const httpOptions = {
      headers: new HttpHeaders({
        'Authorization': 'Basic ' + btoa(user.email + ':' + user.password)
      })
    };
    return this.http.post(`${environment.api_url}` + '/auth/signin', null, httpOptions)
      .pipe(catchError(this.formatErrors));
  }
}
