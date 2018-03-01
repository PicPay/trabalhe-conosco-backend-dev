import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';


import {AppComponent} from './app.component';
import {AppRoutingModule} from './app-routing.module';
import {HomeComponent} from './home/home.component';
import {SharedModule} from './shared/shared.module';
import {JWT_OPTIONS, JwtHelperService, JwtModule} from '@auth0/angular-jwt';
import {JwtService} from './shared/services/jwt.service';
import {environment} from '../environments/environment';
import {HeaderComponent} from './shared/layout/header.component';
import {UserService} from './shared/services/user.service';
import {ApiService} from './shared/services/api.service';
import {AuthGuard} from './shared/services/auth.guard';
import {UsersService} from "./shared/services/users.service";
import {PaginationService} from "./shared/services/pagination.service";

export function jwtOptionsFactory(jwtService: JwtService) {
  return {
    tokenGetter: () => {
      return jwtService.getToken();
    },
    whitelistedDomains: ['desafio-pp.local:8010']
  };
}

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    HeaderComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    SharedModule,
    JwtModule.forRoot({
      jwtOptionsProvider: {
        provide: JWT_OPTIONS,
        useFactory: jwtOptionsFactory,
        deps: [JwtService]
      }
    })
  ],
  providers: [
    JwtHelperService,
    JwtService,
    UserService,
    ApiService,
    AuthGuard,
    UsersService,
    PaginationService
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
