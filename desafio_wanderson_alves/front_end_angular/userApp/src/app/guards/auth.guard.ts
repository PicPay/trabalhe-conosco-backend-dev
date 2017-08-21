import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router} from "@angular/router";
import { Observable } from "rxjs/Observable";

import { AuthService } from './../services/auth.service';

@Injectable()
export class AuthGuard implements CanActivate {

  constructor(private authService: AuthService,
              private router: Router) { }

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | boolean {

    if (this.authService.authenticatedUser()) {
      return true;
    }
    this.router.navigate(['/login']);
    return false;

  }

}
