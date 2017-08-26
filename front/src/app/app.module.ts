import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import{ HttpModule } from '@angular/http'
import { AppComponent } from './app.component';
import { TableComponent } from './table/table.component';

import { DataService } from './services/data.service';
import { TabelaComponent } from './tabela/tabela.component'
@NgModule({
  declarations: [
    AppComponent,
    TableComponent,
    TabelaComponent
  ],
  imports: [
    BrowserModule,
    HttpModule
  ],
  providers: [DataService],
  bootstrap: [AppComponent]
})
export class AppModule { }
