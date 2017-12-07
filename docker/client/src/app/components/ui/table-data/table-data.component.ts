import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

import { User } from '../../../models';

@Component({
  selector: 'app-table-data',
  templateUrl: './table-data.component.html',
  styleUrls: ['./table-data.component.css']
})
export class TableDataComponent implements OnInit {

  @Input('users') users: User[];
  @Input('hasNextPage') hasNextPage: boolean;
  @Input('currentPage') currentPage: number;

  @Output('onPageChanged') onPageChangedEmiter: EventEmitter<any> = new EventEmitter<any>();

  constructor() { }

  ngOnInit() {
  }

  /**
   * Emite o evento de avançar a página.
   *
   * @author L.Gomes
   */
  pageNext(): void {
    if (this.hasNextPage) {
      this.currentPage++;
      this.onPageChangedEmiter.emit({pageNumber: this.currentPage});
    }
  }

  /**
   * Emite o evento de voltar a página.
   *
   * @author L.Gomes
   */
  pagePrevious(): void {
    if (!(this.currentPage === 1)) {
      this.currentPage--;
      this.onPageChangedEmiter.emit({pageNumber: this.currentPage});
    }
  }
}
