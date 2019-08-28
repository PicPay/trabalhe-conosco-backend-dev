import { Injectable } from '@angular/core';
import { Usuario } from '../Usuario';
import { Http, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/do';


@Injectable()
export class UsuarioService {
    private _NomeUrl = `http://localhost:8080/buscarNome`;
    private _UsernameUrl = `http://localhost:8080/buscarUsername`;

    constructor(private _http: Http) { }
    
    getDadosPeloNome(nome: string): Observable<Usuario> {
        return this._http.get(this._NomeUrl + '?nome=' + nome)
            .map((response: Response) => <Usuario>response.json())
            .do(data => console.log('All: ' + JSON.stringify(data)))
            .catch(this.handleError);
    }

    getDadosPeloUsername(username: string): Observable<Usuario> {
        return this._http.get(this._UsernameUrl + '?username=' + username)
            .map((response: Response) => <Usuario>response.json())
            .do(data => console.log('All: ' + JSON.stringify(data)))
            .catch(this.handleError);
    }

    private handleError(error: Response) {
        console.error(error);
        return Observable.throw(error.json().error || 'Server error');
    }
}