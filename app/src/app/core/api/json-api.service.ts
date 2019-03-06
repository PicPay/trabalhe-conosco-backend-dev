import { Injectable } from '@angular/core';
import {Http, Response} from "@angular/http";

import {config} from '../../shared/smartadmin.config';
import {Observable} from "rxjs/Rx";

import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/do';

@Injectable()
export class JsonApiService {

  constructor(private http: Http) {}

  public fetch(url): Observable<any>{
    return this.http.get(this.getBaseUrl() + config.API_URL + url)
      .delay(100)
      .map(this.extractData)
      .catch(this.handleError)
  }

  private getBaseUrl(){
      console.log(location.protocol + '//' + location.hostname + (location.port ? ':'+location.port : '') + '/')
    return location.protocol + '//' + location.hostname + (location.port ? ':'+location.port : '') + '/'
  }

  private extractData(res:Response) {
    let body = res.json();
    if (body){
      return body.data || body
    } else {
      return {}
    }
  }

  private handleError(error:any) {
    // In a real world app, we might use a remote logging infrastructure
    // We'd also dig deeper into the error to get a better message
    let errMsg = (error.message) ? error.message :
      error.status ? `${error.status} - ${error.statusText}` : 'Server error';
    console.error(errMsg); // log to console instead
    return Observable.throw(errMsg);
  }

}
