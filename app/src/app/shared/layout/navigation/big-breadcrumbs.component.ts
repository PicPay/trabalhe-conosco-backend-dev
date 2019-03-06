import {Component, OnInit, Input} from '@angular/core';

@Component({

  selector: 'sa-big-breadcrumbs',
  template: `
   <div><h1 class="page-title txt-color-blueDark">
   <i class="fa-fw fa fa-{{icon}}"></i>{{items[0]}}
   <span *ngFor="let item of items.slice(1)">> {{item}}</span>
</h1></div>
  `,
})
export class BigBreadcrumbsComponent implements OnInit {

  @Input() public icon: string;
  @Input() public items: Array<string>;


  constructor() {}

  ngOnInit() {
  }

}
