import {Component, OnDestroy, OnInit} from '@angular/core';
import {UsersService} from '../../shared/services/users.service';
import {Subscription} from 'rxjs/Subscription';
import {ListResult} from '../../shared/models/list-result.interface';
import {User} from '../../shared/models/user';
import {ActivatedRoute} from '@angular/router';
import {PaginationService} from '../../shared/services/pagination.service';

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
})
export class UsersListComponent implements OnInit, OnDestroy {

  public usersList: ListResult<User>;
  public loading = false;
  public queryParams: any[];
  public pager: {};
  private perpage = 15;
  private subscription: Subscription;
  public searchString: string;

  constructor(private usersService: UsersService,
              private route: ActivatedRoute,
              private pagination: PaginationService) {
  }

  ngOnInit() {
    this.subscription = this.route.queryParams.subscribe(
      params => {
        this.queryParams = this.pagination.handleQueryParams(params);
        this.loadUsers();
      }
    );
  }

  loadUsers() {
    const defaults: any[] = [{'perpage': this.perpage}];
    this.loading = true;

    if (this.searchString != null && this.searchString.trim() !== '') {
      this.queryParams.push({['filter']: this.searchString});
    }

    this.usersService.query(this.queryParams, defaults).subscribe(
      response => {
        this.loading = false;
        this.usersList = response;
        this.pager = this.pagination.getPager(this.usersList.total, this.perpage);
      }
    );
  }

  clear() {
    this.queryParams = [];
    this.loadUsers();
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

}
