import { Component, OnInit } from '@angular/core';

import { AuthService } from './../../services/auth.service';
import { User } from './../../domain/user';

@Component({
selector: 'app-login',
templateUrl: './login.component.html',
styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  private user: User = new User();
  autUser: boolean = true;
  preloader : boolean = false;

  constructor(private authService: AuthService) { }

  ngOnInit() {}

  login(){

    this.preloader = true;
    this.authService.login(this.user);
    this.authService.autUser.subscribe(
      menu =>  this.executeLogin(menu)
    );

  }

  executeLogin(val:boolean){
    this.autUser =  val;
    this.preloader = false;
  }

}
