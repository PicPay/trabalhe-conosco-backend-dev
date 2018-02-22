import { LocationStrategy, HashLocationStrategy } from '@angular/common';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpModule, BrowserXhr } from '@angular/http';
import { AppRoutes } from './app.routes';
import { AppComponent } from './app.component';
import { PaginationModule } from 'ngx-bootstrap';

import { SearchBarComponent, TableDataComponent, MainComponent } from './components';
import { UserService, HttpTalkerService, CustExtBrowserXhr } from './services';
import { FloorPipe } from './pipes';

@NgModule({
  declarations: [
    AppComponent,
    SearchBarComponent,
    TableDataComponent,
    MainComponent,
    FloorPipe,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    AppRoutes,
    PaginationModule.forRoot(),
  ],
  providers: [
    {provide: BrowserXhr, useClass:CustExtBrowserXhr},
    UserService,
    HttpTalkerService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
