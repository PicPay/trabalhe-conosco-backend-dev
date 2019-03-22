import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { FormsModule } from '@angular/forms';


import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { UsersComponent } from './users/users.component';
import { NoopAnimationsModule } from '@angular/platform-browser/animations';
import { CustomMaterialModule } from './CustomMaterialModule';
import { FlexLayoutModule } from '@angular/flex-layout';
import { JwtInterceptor } from './interceptors/JwtInterceptor';
import { MatPaginatorModule } from '@angular/material/paginator'; 

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    UsersComponent
  ],
  imports: [
    BrowserModule,
    FlexLayoutModule,
    MatPaginatorModule,
    HttpClientModule,
    AppRoutingModule,
    CustomMaterialModule,
    FormsModule,
    NoopAnimationsModule
  ],
  providers: [{provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true}],
  bootstrap: [AppComponent]
})
export class AppModule { }
