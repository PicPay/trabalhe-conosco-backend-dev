import {Injectable} from '@angular/core';

import {UserAuth} from '../models/user-auth';
import {ApiService} from './api.service';
import {JwtService} from './jwt.service';
import {JwtHelperService} from '@auth0/angular-jwt';
import {distinctUntilChanged, map} from 'rxjs/operators';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Observable} from 'rxjs/Observable';

@Injectable()
export class UserService {

  private currentUserSubject = new BehaviorSubject<UserAuth>({} as UserAuth);
  public currentUser = this.currentUserSubject.asObservable().pipe(distinctUntilChanged());

  private isAuthenticatedSubject = new ReplaySubject<boolean>(1);
  public isAuthenticated = this.isAuthenticatedSubject.asObservable();

  constructor(private apiService: ApiService,
              public jwtHelper: JwtHelperService,
              private jwtService: JwtService) {
  }

  // Verify JWT in localstorage with server & load user's info.
  // This runs once on application startup.
  populate() {
    const token: string = this.jwtService.getToken();
    // If JWT detected, attempt to get & store user's info
    if (token && !this.jwtHelper.isTokenExpired()) {
      const user: UserAuth = this.jwtHelper.decodeToken(token).user;
      this.apiService.get('/users-auth/' + user.email)
        .subscribe(
          data => this.setAuth(data, token),
          err => this.purgeAuth()
        );
    } else {
      // Remove any potential remnants of previous auth states
      this.purgeAuth();
    }
  }

  setAuth(user: UserAuth, token: string = '') {
    // Save JWT sent from server in localstorage
    if (token !== '') {
      this.jwtService.saveToken(token);
    }
    // Set current user data into observable
    this.currentUserSubject.next(user);
    // Set isAuthenticated to true
    this.isAuthenticatedSubject.next(true);
  }

  purgeAuth() {
    // Remove JWT from localstorage
    this.jwtService.destroyToken();
    // Set current user to an empty object
    this.currentUserSubject.next({} as UserAuth);
    // Set auth status to false
    this.isAuthenticatedSubject.next(false);
  }

  attemptAuth(user: UserAuth): Observable<UserAuth> {
    return this.apiService.signin(user)
      .pipe(
        map(
          data => {
            this.setAuth(this.jwtHelper.decodeToken(data.token).user, data.token);
            return data.token;
          }
        )
      );
  }

  getCurrentUser(): UserAuth {
    return this.currentUserSubject.value;
  }
}
