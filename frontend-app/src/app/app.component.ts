import { Component } from '@angular/core';
import { Observable } from 'rxjs';
import { Usuario } from '../Usuario';
import { UsuarioService } from './app.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent {
  title = 'frontend-app';

  usuario: Usuario;
  username: string;
  nome: string;
    
  constructor(private _usuarioService: UsuarioService) {
  }
    PesquisarUsername(): void {
      this._usuarioService.getDadosPeloUsername(this.username)
          .subscribe((data: Usuario) => this.usuario = data,
          error => console.log(error));
    }

    PesquisarNome(): void {
      this._usuarioService.getDadosPeloNome(this.nome)
          .subscribe((data: Usuario) => this.usuario = data,
          error => console.log(error));
    }

}
