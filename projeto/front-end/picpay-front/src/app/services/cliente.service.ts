import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
export class ClienteService {

  // webApiUrl = 'http://localhost:8080/api/clientes/listar';
  webApiUrl = 'http://localhost:8080/api/clientes/listar-paginado/a/1';

  constructor(private http: HttpClient) { }

  public getTodosClientes() {
    return this.http.get<any>(this.webApiUrl);
  }

  public getTodosClientesPaginado(termo: string, page: number) {
    debugger;
    //return this.http.get<any>('http://localhost:8080/api/clientes/listar-paginado/'+ termo + '/' + page);
    return this.http.get<any>('http://localhost:8080/api/users/listagem-usuarios/'+ termo + '/' + page);
    
  }
}
