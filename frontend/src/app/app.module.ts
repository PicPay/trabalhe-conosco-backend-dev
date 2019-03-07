import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule, LOCALE_ID } from '@angular/core';
import { HttpModule } from '@angular/http';
import localePt from '@angular/common/locales/pt';
import { registerLocaleData } from '@angular/common';

import 'rxjs/add/operator/map'
import { AppComponent } from './app.component';
import { UserComponent } from './user/user.component';
import { UserService } from './user/user.service';
import {PaginatorModule} from 'primeng/paginator';
import {ButtonModule} from 'primeng/button';
import {InputTextModule} from 'primeng/inputtext';
import { PaginationComponent } from './pagination/paginacao.component';


registerLocaleData(localePt);
@NgModule({
  declarations: [
    AppComponent,
    PaginationComponent,
    UserComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    BrowserAnimationsModule,
    PaginatorModule,
    ButtonModule,
    InputTextModule
  ],
  providers: [UserService, {provide: LOCALE_ID, useValue: 'pt-BR'}],
  bootstrap: [AppComponent]
})
export class AppModule { }
