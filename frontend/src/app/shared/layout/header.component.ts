import {Component, OnInit} from '@angular/core';
import {UserService} from '../services/user.service';
import {UserAuth} from '../models/user-auth';
import {Router} from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
})
export class HeaderComponent implements OnInit {

  constructor(private userService: UserService, private router: Router) {
  }

  currentUser: UserAuth;

  ngOnInit() {
    this.userService.currentUser.subscribe(
      (userData) => {
        this.currentUser = userData;
      }
    );
  }

  logout() {
    this.userService.purgeAuth();
    this.router.navigateByUrl('/auth/signin');
  }

}
