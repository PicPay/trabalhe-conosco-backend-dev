import { Injectable } from '@angular/core';
import { Response } from '@angular/http';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';

import { AppConfig } from '../../app.config';

import { User } from '../../models';
import { HttpTalkerService } from '../../services/http-talker/http-talker.service';

/**
 * Classe que faz o acesso aos serviços de Usuário no servidor.
 *
 * @author L.Gomes
 */
@Injectable()
export class UserService {

  limitData: number = 15;

  constructor(
    private httpTalker: HttpTalkerService,
  ) { }

  /**
   * Recupera os usuários presentes na base de dados.
   *
   * @param page número da página selecionada
   * @param filter filtro digitado no campo de busca
   * @return Um Observable contendo os usuários retornados pelo servidor
   * @author L.Gomes
   */
  getUsers(page: number, filter?: string): Observable<any> {
    const url: string = `${AppConfig.serverPath}users/${this.limitData}/${page * this.limitData}/${filter || ''}`;
    return this.httpTalker.httpGet(url)
      .map((res: Response) => {
        return res.json();
      });
  }
}
