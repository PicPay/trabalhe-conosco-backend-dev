import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'pagination',
  template: `
  <div class="pagination-container" *ngIf="page && page.totalPages > 0">
      <nav aria-label="Page navigation">
          <ul class="pagination">
              
              <li class="page-item" [ngClass]="page.first ? 'disabled' : '' ">
                  <a  class="page-link" *ngIf="page.first" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
                  <a  class="page-link" style="cursor: pointer" *ngIf="!page.first" (click)="changePage(page.number-1)" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>
  
              <li class="page-item" *ngFor="let pageAux of page.pages" [ngClass]="(pageAux == page.number) ? 'active' : ''"  [ngClass]="i == page.number ? 'active' : '' ">
                  <a class="page-link" style="cursor: pointer" (click)="changePage(pageAux)">{{pageAux+1}}</a>
              </li>
  
              <li class="page-item" [ngClass]="page.last ? 'disabled' : '' ">
                  <a  class="page-link" *ngIf="page.last" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
                  <a  class="page-link" style="cursor: pointer" *ngIf="!page.last" (click)="changePage(page.number+1)" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
              <select (ngModelChange)="changePage()" [(ngModel)]="size" class="custom-select">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
              </select>
          </ul>
      </nav>

  </div>`,
  styleUrls:['./pagination.component.css']
})
export class PaginationComponent implements OnInit {
    private size: number = 10;
    private page; 
    @Input("page") public set value(page : any){
        if(!page) return;
        this.page = page;
        this.setPagetion();
    }
    @Output() public  paginationEvent : EventEmitter<any> = new EventEmitter();

    constructor() { }

    ngOnInit() {}

    changePage(page?){
        setTimeout(()=>{
            this.paginationEvent.emit({page: page? page : 0, size: this.size} );
        });
    }

    setPagetion(){
        let pages = new Array<number>();
        let inc =  (this.page.number - 2) <= 0 ? (4 - this.page.number) : 2;
        let dec =  (this.page.number + 2) >= this.page.totalPages ? (5 - (this.page.totalPages - this.page.number)) : 2;
        let inicio = (this.page.number - dec) <= 0 ? 0 : (this.page.number - dec);
        let fim = (this.page.number + inc) < this.page.totalPages ? (this.page.number + inc) : (this.page.totalPages - 1);
        for(let i = inicio; i<= fim; i++){
            pages.push(i);
        }
        this.page.pages = pages;
    }
}
