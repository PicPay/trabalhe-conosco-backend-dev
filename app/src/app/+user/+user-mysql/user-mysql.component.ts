import {Component, OnInit, ViewChild} from '@angular/core'
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http'

import { Observable } from 'rxjs/Observable'
import 'rxjs/add/operator/do'

import { FadeInTop } from "../../shared/animations/fade-in-top.decorator"
import { DatatableComponent } from "../../shared/ui/datatable/datatable.component"

import { USER_API } from "../../core/api/user.api"

@FadeInTop()
@Component({
    selector: 'sa-user-mysql',
    templateUrl: './user-mysql.component.html'
})
export class UserMysqlComponent implements OnInit {

    public name: any
    public username: any
    public sort: boolean

    public executionTime: string
    public usersList: any
    public usersListOptions: any

    @ViewChild('usersDT')
    private usersDT: DatatableComponent

    constructor(private http: HttpClient) { }

    ngOnInit() {
        this.usersListOptions = {
            processing: true,
            serverSide: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            pageLength: 15,
            language: {
                aria: {
                    sortAscending: ": Ordenar colunas de forma ascendente",
                    sortDescending: ": Ordenar colunas de forma descendente"
                },
                decimal: ",",
                emptyTable: "Nenhum registro encontrado",
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 até 0 de 0 registros",
                infoFiltered: "",
                infoPostFix: "",
                logengthMenu: "_MENU_ resultados por página",
                loadingRecords: "Carregando...",
                paginate: {
                    next: "Próximo",
                    previous: "Anterior",
                    first: "Primeiro",
                    last: "Último"
                },
                processing: "<div class=\"DTTT_print_info\"><h6>Aguarde ...</h6></div>",
                search: "Pesquisar",
                thousands: ".",
                zeroRecords: "Nenhum registro encontrado"
            },
            ajax: (datatable, callback, settings) => {
                this.getUsersListInfo(
                        datatable['draw'],
                        callback,
                        datatable['length'],
                        (parseInt(datatable['start'])/parseInt(datatable['length'])).toString()
                )
            },
            columns: [ {data: 'id', width: '350px'}, {data: 'name', width: '720px'}, {data: 'username'} ]
        }
    }

    getUsersListInfo(draw, callback, items_count_per_page, page){
        let headers = new HttpHeaders()
            .set('Access-Control-Allow-Origin', '*')
        let params = new HttpParams()
            .set('name', this.name === undefined ? '' : this.name)
            .set('username', this.username === undefined ? '' : this.username)
            .set('sort', this.sort === undefined ? "0" : (this.sort ? "1" : "0"))
            .set('size', items_count_per_page)
            .set('page', page)
        this.http.get<any>(USER_API, {headers:headers, params:params})
                 .subscribe(data => {
                    this.usersList = []
                     this.executionTime = data.time

                    if(data === undefined || (data.users instanceof Array && data.users.length === 0)){
                       data.users = []
                    }

                    for (let i in data.users) {
                       this.usersList.push({
                           id: data.users[i].id,
                           name: data.users[i].name,
                           username: data.users[i].username
                       })
                    }
                    callback({
                        draw: parseInt(draw),
                        refecordsTotal: parseInt(data.totalUsers),
                        recordsFiltered: parseInt(data.totalUsers),
                        data: this.usersList
                    })
                })
    }

    filter(){
        this.usersDT.reloadAjax()
    }
}
