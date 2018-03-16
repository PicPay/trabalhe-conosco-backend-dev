import {Injectable} from '@angular/core';
import {CanActivate, Router, CanLoad, Route} from '@angular/router';
import {JwtHelperService} from '@auth0/angular-jwt';
import {Observable} from "rxjs";
import {UserService} from "./user.service";
import {map, take} from "rxjs/operators";

@Injectable()
export class AuthGuard implements CanActivate, CanLoad {

  constructor(private router: Router, public jwtHelper: JwtHelperService, private userService: UserService) {
  }

  canActivate() {
    return this.isAuthenticated();
  }

  canLoad(route: Route): Observable<boolean> | Promise<boolean> | boolean {
    return this.isAuthenticated();
  }

  private isAuthenticated() {
    if (this.jwtHelper.tokenGetter() && !this.jwtHelper.isTokenExpired()) {
      return true;
    } else {
      this.userService.purgeAuth();
      this.router.navigate(['/auth/signin']);
      return false;
    }
  }
}
