import { Component, OnInit, ViewChild } from "@angular/core";
import { MatTableDataSource, MatPaginator } from "@angular/material";
import { UserService } from "../services/user.service";

@Component({
  selector: "app-users",
  templateUrl: "./users.component.html",
  styleUrls: ["./users.component.css"]
})
export class UsersComponent implements OnInit {
  constructor(private userService: UserService) {}

  

  users: any;
  total = 0;
  page = 0;
  query="";
  displayedColumns = ["id", "name", "username"];

  dataSource = new MatTableDataSource(this.users);

  @ViewChild(MatPaginator) paginator: MatPaginator;

  ngOnInit() {    
    this.load(this.page.toString());
  }

  search(){
    this.page=0;
    this.load(this.page.toString());
    this.paginator.pageIndex = 0;
  }

  load(page : string) {
    this.userService.search(this.query, this.page.toString()).subscribe(
      data => {
        this.users = data.body;

        this.dataSource = new MatTableDataSource(this.users);
        this.total = parseInt(data.headers.get("X-Total-Count"));
        
      },
      error => {
        alert("Ocorreu um erro na busca");
      }
    );
  }

  pageChangeEvent(e){
    console.log(e);
    this.page=e.pageIndex;
    this.load(this.page.toString());
  }
}
