import { Injectable } from "@angular/core";
import { BrowserXhr } from "@angular/http";

/**
 * Serviço para comunicação com o CORS do servidor.
 *
 * @author L.Gomes
 */
@Injectable()
export class CustExtBrowserXhr extends BrowserXhr {
  constructor() {
    super();
  }
  build(): any {
    let xhr = super.build();
    xhr.withCredentials = true;
    return <any>(xhr);
  }
}
