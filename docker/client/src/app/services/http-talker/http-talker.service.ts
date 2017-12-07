import { Injectable } from '@angular/core';
import { Http, Response, Headers } from '@angular/http';

import { Observable } from 'rxjs/Rx';

import { User } from '../../models';

/**
 * Classe responsável por gerenciar as requisições básicas para camada de serviço.
 *
 * @author L.Gomes
 */
@Injectable()
export class HttpTalkerService {

  constructor(
    private http: Http,
  ) { }

  /**
   * Retorna um Observable de uma requisição GET.
   *
   * @author L.Gomes
   */
  httpGet(url: string): Observable<Response> {
    return this.http.get(url);
  }

  /**
   * Retorna os cabeçalhos padrão de conexão com o servidor.
   *
   * @author L.Gomes
   */
  private getAuthorizationHeaders(): Headers {
    let headers: Headers = new Headers();

    headers.append('Access-Control-Expose-Headers', 'Authorization');
    headers.append("Access-Control-Allow-Origin", "http://localhost:4200/");
    headers.append("Access-Control-Allow-Methods", "*");
    headers.append("Access-Control-Allow-Headers", "Accept,Accept-Charset,Accept-Encoding,Accept-Language,Authorization,Connection,Content-Type,Cookie,DNT,Host,Keep-Alive,Origin,Referer,User-Agent,X-CSRF-Token,X-Requested-With");
    headers.append("Access-Control-Allow-Credentials", "true");

    return headers;
  }
}
