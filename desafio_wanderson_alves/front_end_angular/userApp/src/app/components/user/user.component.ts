import { Component, OnInit } from '@angular/core';

import { Pagination } from './../../domain/pagination';
import { UserService } from './../../services/user.service';
import { User } from './../../domain/user';

@Component({
selector: 'app-user',
templateUrl: './user.component.html',
styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  next: number;
  page: number;
  search: string;
  indicator: number;
  hasNext: boolean;
  preloader: boolean;

  pagination: Pagination[] = [];
  users: User[]= [];

  constructor(private userService: UserService) {
    this.addElementList(-1, 1);
  }

  ngOnInit() {

    this.search = '';
    this.next = 15;
    this.page = 1;
    this.indicator = 0;
    this.hasNext = true;
    this.preloader = true;

    this.userService.getUsers(this.page, this.next, this.search).subscribe(
    resp => this.loadListUser(resp),
    error => console.log(error));

  }

  onClick(pag: Pagination) {

    if (this.hasNext) {
      this.preloader = true;
      this.actionNumPag((pag.id - 2), 'waves-effect');
      pag.className = 'active';
      this.indicator = pag.id;
      this.page = pag.id;

      this.userService.getUsers(this.page, this.next, this.search).subscribe(
      resp => this.loadListUser(resp),
      error => console.log(error));
    }

  }

  onLeftButton() {

    if (this.hasNext) {
      this.preloader = true;
      this.page--;
      if (this.indicator <= 0) {
        this.indicator  = 0;
      }else {
        if (this.indicator > 4) {
          this.addElementList(this.indicator , -1);
        }else {
          this.actionNumPag(this.indicator, 'waves-effect');
          this.actionNumPag((this.indicator - 1), 'active');
        }
      }

      this.userService.getUsers(this.page, this.next, this.search).subscribe(
      resp => this.loadListUser(resp),
      error => console.log(error));

      this.indicator--;
    }
  }

  onRightButton() {

    if (this.hasNext) {
      this.preloader = true;
      this.indicator++;
      this.page++;
      console.log(this.indicator);
      if (this.indicator > 4) {
        this.addElementList(this.indicator + 1, -1);
      } else {
        this.actionNumPag((this.indicator - 1), 'waves-effect');
        this.actionNumPag(this.indicator, 'active');
      }

      this.userService.getUsers(this.page, this.next, this.search).subscribe(
      resp => this.loadListUser(resp),
      error => console.log(error));

    }

  }

  onSearch(sch) {

    this.search = sch.value;
    this.preloader = true;

    this.userService.getUsers(this.page, this.next, this.search).subscribe(
    resp => this.loadListUser(resp),
    error => console.log(error));

  }

  actionNumPag(numPag: number, action: string) {

    this.pagination[(numPag <= 0) ? 0 : (numPag) ].className = action;

  }

  addElementList(lastPag: number, firstPag: number) {

    this.pagination.splice(0, 5);
    let isLast: boolean = lastPag > 0 ? true : false;
    let numPag = isLast ? lastPag : firstPag;
    for (let i = 0; i < 5; i++) {
      this.pagination[i] = { id: numPag  , name: numPag.toString(), className : i === 0 ? 'active' : 'waves-effect' };
      numPag = isLast ? numPag - 1 : numPag + 1;
    }
    this.pagination.sort(function(a, b){return a.id - b.id});

  }

  loadListUser(resp: User[]) {

    this.users = resp;
    this.hasNext = resp.length < 15 ? false : true;
    this.preloader = false;
  }

}
