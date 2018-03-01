import {Component, Input} from '@angular/core';
import {ApiService} from '../services/api.service';
import {ListResult} from "../models/list-result.interface";
import {PaginationService} from "../services/pagination.service";

@Component({
  selector: 'app-pagination',
  templateUrl: './pagination.component.html',
})
export class PaginationComponent {

  @Input() itemList: ListResult<any>;
  @Input() pager: {
    currentPage?: number;
    pages?: any[];
  };
  @Input() routerName: string;

  constructor(private paginationService: PaginationService) {
  }

  routerQueryParams(action: string = null, page: number = null): {} {
    return this.paginationService.buildRouterQueryParams(this.itemList, null, action, page);
  }
}
