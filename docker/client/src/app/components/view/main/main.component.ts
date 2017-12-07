import { Component, OnInit } from '@angular/core';

import { User } from '../../../models';
import { UserService } from '../../../services';

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.css']
})
export class MainComponent implements OnInit {

  users: User[];
  hasNextPage: boolean;
  currentPage: number;
  filter: string;

  constructor(
    private userService: UserService
  ) { }

  ngOnInit() {
    this.currentPage = 1;
    this.getUsers();
  }

  /**
   * Recupera uma lista de usuários para preencher a tabela.
   *
   * @author L.Gomes
   */
  getUsers(): void {
    this.userService.getUsers(this.currentPage, this.filter).subscribe(
      response => {
        this.users = response.users;
        this.hasNextPage = response.hasNextPage;
      }, error => {
        console.error(error.json());
        this.users = [];
        this.hasNextPage = false;
      }
    )
  }

  /**
   * Atualiza a lista de usuários de acordo com o filtro.
   *
   * @param event evento emitido pelo componente de filtro,
   *  contendo o conteúdo digitado pelo usuário
   * @author L.Gomes
   */
  filterChange(event: any): void {
    this.filter = event.filterActive;
    this.currentPage = 1;
    this.getUsers();
  }

  /**
   * Atualiza a lista de usuários de acordo com a página selecionada.
   *
   * @param event evento emitido pelo componente da tabela, contendo o número da página atual
   * @author L.Gomes
   */
  pageChange(event: any): void {
    this.currentPage = event.pageNumber;
    this.getUsers();
  }
}
