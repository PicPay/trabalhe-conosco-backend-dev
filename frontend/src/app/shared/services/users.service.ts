import {Injectable} from '@angular/core';
import {ApiService} from './api.service';
import {Observable} from 'rxjs/Observable';
import {ListResult} from '../models/list-result.interface';
import {User} from '../models/user';
import {HttpParams} from '@angular/common/http';

@Injectable()
export class UsersService {

  constructor(private apiService: ApiService) {
  }

  query(params: any[], defaults: any[] = [], url: string = ''): Observable<ListResult<User>> | any {

    const urlSearchParams = {};

    const handlerParams = function (item: {}) {
      Object.keys(item).forEach(function (key) {
        urlSearchParams[key] = item[key];
      });
    };

    params.forEach(handlerParams);
    defaults.forEach(handlerParams);

    if (url) {
      const urlQueryParams = url.split('?')[1].split('&');
      urlQueryParams.forEach(function (value) {
        urlSearchParams[value.split('=')[0]] = value.split('=')[1];
      });
    }

    return this.apiService.get('/users', new HttpParams({fromObject: urlSearchParams}))
      .pipe(response => response);
  }

}
