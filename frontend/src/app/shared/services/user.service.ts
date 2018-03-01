import {Injectable} from '@angular/core';

import {User} from '../models/user';
import {ApiService} from './api.service';
import {JwtService} from './jwt.service';
import {JwtHelperService} from '@auth0/angular-jwt';
import {distinctUntilChanged, map} from 'rxjs/operators';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Observable} from 'rxjs/Observable';

@Injectable()
export class UserService {

  private currentUserSubject = new BehaviorSubject<User>({} as User);
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
      const user: User = this.jwtHelper.decodeToken(token).user;
      this.apiService.get('/users/' + user.email)
        .subscribe(
          data => this.setAuth(data, token),
          err => this.purgeAuth()
        );
    } else {
      // Remove any potential remnants of previous auth states
      this.purgeAuth();
    }
  }

  setAuth(user: User, token: string = '') {
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
    this.currentUserSubject.next({} as User);
    // Set auth status to false
    this.isAuthenticatedSubject.next(false);
  }

  attemptAuth(user: User): Observable<User> {
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

  getCurrentUser(): User {
    return this.currentUserSubject.value;
  }
}
