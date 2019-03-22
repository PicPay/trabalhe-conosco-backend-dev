import { Injectable } from "@angular/core";
import { HttpClient, HttpParams } from "@angular/common/http";
import { Observable } from "rxjs";

@Injectable({
  providedIn: "root"
})
export class UserService {
  uri = "http://localhost:8080/api";

  constructor(private httpClient: HttpClient) {}

  search(query: string, page: string) {

    let params = new HttpParams();

    params = params.append('query', query);
    params = params.append('page', page);
    

    return this.httpClient.get(this.uri + "/usr-data", {
      params: params,
      observe: "response"
    });
  }

  get(req?: any): Observable<any> {
    const options = this.createRequestOption(req);
    return this.httpClient.get<any[]>(this.uri + "/usr-data", {
      params: options,
      observe: "response"
    });
  }

  createRequestOption = (req?: any): HttpParams => {
    let options: HttpParams = new HttpParams();
    if (req) {
      Object.keys(req).forEach(key => {
        if (key !== "sort") {
          options = options.set(key, req[key]);
        }
      });
      if (req.sort) {
        req.sort.forEach(val => {
          options = options.append("sort", val);
        });
      }
    }
    return options;
  };
}
