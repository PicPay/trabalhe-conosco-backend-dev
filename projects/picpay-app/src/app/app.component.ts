import {Component, OnChanges, OnInit} from '@angular/core';
import { ApiService } from './api.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent implements OnInit {

  private _url: string;
  private _dados: any;

  private _current_page: string;
  private _current_page_url: string;
  private _first_page_url: string;
  private _prev_page_url: string;
  private _next_page_url: string;

  private _total: string;

  constructor(private apiService: ApiService) {
    console.log(this.url);
  }

  ngOnInit() {
    this.getUser();
  }

  public submitSearch(serchValue: string) {
    this.dados = null;
    this.apiService.search(serchValue).subscribe((dados) => {
      this.dados = dados.body.data;
      this.current_page = dados.body.current_page;
      this.current_page_url = dados.url;
      this.first_page_url = dados.body.first_page_url;
      this.prev_page_url = dados.body.prev_page_url;
      this.next_page_url = dados.body.next_page_url;
      this.total = dados.body.last_page;
    });
  }

  public onClickUrl(url: string) {
    this.url = url;
    this.getUser(this.url);
  }

  public get url(): string {
    return this._url;
  }

  public set url(value: string) {
    this._url = value;
  }

  public get dados(): any {
    return this._dados;
  }

  public set dados(value: any) {
    this._dados = value;
  }

  public get current_page(): string {
    return this._current_page;
  }

  public set current_page(value: string) {
    this._current_page = value;
  }

  public get current_page_url(): string {
    return this._current_page_url;
  }

  public set current_page_url(value: string) {
    this._current_page_url = value;
  }

  public get first_page_url(): string {
    return this._first_page_url;
  }

  public set first_page_url(value: string) {
    this._first_page_url = value;
  }

  public get prev_page_url(): string {
    return this._prev_page_url;
  }

  public set prev_page_url(value: string) {
    this._prev_page_url = value;
  }

  public get next_page_url(): string {
    return this._next_page_url;
  }

  public set next_page_url(value: string) {
    this._next_page_url = value;
  }

  public get total(): string {
    return this._total;
  }

  public set total(value: string) {
    this._total = value;
  }

  private getUser(url?: string) {
    this.apiService.getUsers(url).subscribe((dados) => {
      this.dados = dados.body.data;
      this.current_page = dados.body.current_page;
      this.current_page_url = dados.url;
      this.first_page_url = dados.body.first_page_url;
      this.prev_page_url = dados.body.prev_page_url;
      this.next_page_url = dados.body.next_page_url;
      this.total = dados.body.last_page;
    });
  }
}
