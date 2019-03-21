import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { tap } from 'rxjs/operators';

@Injectable({
  providedIn: "root"
})
export class JwtService {

  uri = 'http://localhost:8080/api';

  constructor(private httpClient: HttpClient) {}

  login(username: string, password: string) {

    let contentHeader = new HttpHeaders({ "Content-Type": "application/json" });
    
    return this.httpClient
      .post<any>(this.uri+"/authenticate", {
        username,
        password
      }, {headers: contentHeader, observe: "response"})      
      .pipe(
        tap(res => {               
          localStorage.setItem("access_token", res.headers.get("Authorization"));
        })
      );
      
  }


  logout() {
    localStorage.removeItem('access_token');
  }

  public get loggedIn(): boolean{
    return localStorage.getItem('access_token') !==  null;
  }

}
