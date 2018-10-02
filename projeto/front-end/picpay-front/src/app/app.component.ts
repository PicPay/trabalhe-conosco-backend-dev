import { Component } from '@angular/core';
import { ClienteService } from './services/cliente.service';
import { Cliente } from './models/cliente';

import { LazyLoadEvent, Message, MessageService } from '../../node_modules/primeng/api';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

  clienteList: Cliente[];
  loading: boolean = false;
  totalRecords = 0;
  rows = 0;
  cols: any[];
  txtPesquisa: string;
  msgs: Message[] = [];


  constructor(private clienteService: ClienteService) { }

  ngOnInit() {
    this.cols = [      
      { field: 'nome', header: 'Nome' },
      { field: 'username', header: 'Username' },
      { field: 'prioridade', header: 'Prioridade' }
    ];
  }

  getTodosClientes() {
    debugger;
    this.clienteService.getTodosClientes().subscribe(
      data => {
        console.log(data);
        console.log("page number: " + data.number);
        console.log("number of elements: " + data.numberOfElements);
        console.log("elements on page: " + data.size);
        console.log("total of elements: " + data.totalElements);
        console.log("total pages: " + data.totalPages);
        this.clienteList = data.content;
      }
    );
  }

  loadCarsLazy(event: LazyLoadEvent) {

    if (this.txtPesquisa != undefined || this.txtPesquisa != null) {
      this.loading = true;

      this.clienteService.getTodosClientesPaginado(this.txtPesquisa, event.first/event.rows).subscribe(
        data => {
          this.clienteList = data.content;
          this.totalRecords = data.totalElements;
          this.rows = data.size;
          event.rows = data.size;
          this.loading = false;
        }
      );
    }
  }

  clickPesquisar() {
    if (this.txtPesquisa == undefined || this.txtPesquisa == "") {
      this.msgs = [];
      this.msgs.push( { severity:'error', detail:'Preenchimento obrigatório' } );
      return false;
    } 
    this.msgs = [];
    this.loading = true;
    
    this.clienteService.getTodosClientesPaginado(this.txtPesquisa, 0).subscribe(
      data => {
        this.clienteList = data.content;
        this.totalRecords = data.totalElements;
        this.rows = data.size;
        this.loading = false;
      }
    );
  }
}
