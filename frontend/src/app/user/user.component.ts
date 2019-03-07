import { Component, OnInit } from '@angular/core';
import { UserService } from './user.service';
import { User, Page } from '../models/models';


@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  private users: Array<User> = []
  private page : Page;
  private totalElements : Number;
  private key : String = "";
  constructor(private service: UserService) { }

  ngOnInit() {
    // this.pageUsers(0,10);
  }

  buscar(key){
    this.key = key;
    this.pageUsers(0,10);
  }

  listUsers(){
    this.service.getUserList().subscribe(res => {
      this.users = res;
    });
  }

  pageUsers(page, size){
    this.service.getUserPage(this.key, page, size).subscribe(res => {
      this.page = res
      this.users = this.page.content;
      this.totalElements = this.page.totalElements;
    });
  }

  changePage(event){
   this.pageUsers(event.page, event.size);
  }

}
