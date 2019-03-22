import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
 
import { JwtService } from '../services/jwt.service';
 
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  email = '';
  password = '';
   
  constructor(private authService: JwtService, private router: Router) {
     
  }

  login() {
  console.log("you are logging in")  

  this.authService.login(this.email, this.password).subscribe(
    data => {     
      this.router.navigate(['users']);
    },
    error =>{
      alert("Usuário ou senha inválidos");
    }
  );
   
  }
 
  ngOnInit() { }
}