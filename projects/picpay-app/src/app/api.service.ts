import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class ApiService {

  private _apiURL: string;
  private _headers: any;

  constructor(private httpClient: HttpClient) {
    this.apiURL = 'http://localhost:8000/api';
    this.headers = {
      headers: new HttpHeaders({
        'Content-Type':  'application/json',
        'Access-Control-Allow-Origin': '*',
        'Authorization': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZkYWMzN2M4NTVjYTA1NjU1ZDFlZjFmYzUxNTkxODNjYzJjY2NjMGUzNWFhOGZiNTIwNmYyNGY4MTg1YjY0MGIzNzYxOGU1NTAzMGU5ZWU1In0.eyJhdWQiOiIzIiwianRpIjoiZmRhYzM3Yzg1NWNhMDU2NTVkMWVmMWZjNTE1OTE4M2NjMmNjY2MwZTM1YWE4ZmI1MjA2ZjI0ZjgxODViNjQwYjM3NjE4ZTU1MDMwZTllZTUiLCJpYXQiOjE1NDY4MTA5MjYsIm5iZiI6MTU0NjgxMDkyNiwiZXhwIjoxNTc4MzQ2OTI1LCJzdWIiOiIwIiwic2NvcGVzIjpbXX0.1dZugrUcT9xNlvdYFZthAcVzgIBT1vXoXwVN64FKbU7W4ThH2_eCs9ho3YhAepTMgNwmCTBsWbjRRBjgiCYxpC27sai5mOe6TS3GGOQwIls7x6dVYCpklCMFZkIuGxUZhcklLonfliQ4cUptWvBXcvh4BYYhy4G6IVgqYhe3LYJvuYHzGMxCa7XxqKCz7kWYIZ0t2V2ZMdKVQGyyfYFh7qQiFCQM4FfqAdRLhzCaRDFrjGrzOe3DeY201-6yMpBaKrJhuUkv3v6CyYR3YH3ReNrHIMZ-t12pPu9eQiXytRxHEaQm5i1eEOuQ8R0WnXzwMY_Om-yanr5bj9073yuo-WEjrqrjXxKdiJkrMC7y9GwKZ9Cj9sa0ngennR7-VtK_ju6GMbewCZh2JxZFTmxqQA-Dpcs2x22uSfjwWDEVORB1o_v3DYdZavRzGfXuI1rF_nRbhWhyumNmzls-F1eKoWcABcErCgAfID-y6AoAbCwts31JHxplD3d1kFdfszfcham8FXl13fbTSMYWkGAiqY1ykws428SDqd5sUfvyEHpSmsDAhYt5cTxgGlntm4wDtWT2Rsnup8Zx_3r0nyKSvLztE-WXIcISBskA0l_Nj78xVCuCbwCIOYzcY8n5lRmKsT_biXsuy2X7hs4S-FiFCaeehVBGgaJ93mis6RC6EP0'
      })
    };
  }

  public getUsers(url?: string) {

    if (url) {
      return this.httpClient.get<any>(url,
        { observe: 'response', headers: this.headers }).pipe(tap(res => {}));
    }

    return this.httpClient.get<any>(`${this.apiURL}/users`,
      { observe: 'response', headers: this.headers }).pipe(tap(res => {}));
  }

  public search(word: string, url?: string) {

    const params = new HttpParams()
      .set('word', word);

    if (url) {
      return this.httpClient.get<any>(url,
        { observe: 'response', headers: this.headers, params: params})
        .pipe(tap(res => {}));
    }

    return this.httpClient.get<any>(`${this.apiURL}/search`,
      { observe: 'response', headers: this.headers, params: params})
      .pipe(tap(res => {}));
  }

  get apiURL(): string {
    return this._apiURL;
  }

  set apiURL(value: string) {
    this._apiURL = value;
  }

  get headers(): any {
    return this._headers;
  }

  set headers(value: any) {
    this._headers = value;
  }

}
