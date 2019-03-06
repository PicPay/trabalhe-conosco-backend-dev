import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router, NavigationEnd} from "@angular/router";

@Component({
  selector: 'sa-route-breadcrumbs',
  template: `
        <ol class="breadcrumb">
           <li *ngFor="let item of items">{{item}}</li>
        </ol>
  `,
  styles: []
})
export class RouteBreadcrumbsComponent implements OnInit {

  public items: Array<string> = [];

  constructor(
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit() {

    this.router.events
      .filter(e => e instanceof NavigationEnd)
      .subscribe(v => {
        this.items = [];
        this.extract(this.router.routerState.root)
      });

  }

  extract(route){
    let pageTitle = route.data.value['pageTitle'];
    if(pageTitle && this.items.indexOf(pageTitle) == -1){
      this.items.push(route.data.value['pageTitle'])
    }
    if(route.children){
      route.children.forEach(it=>{
        this.extract(it)
      })
    }
  }


}
