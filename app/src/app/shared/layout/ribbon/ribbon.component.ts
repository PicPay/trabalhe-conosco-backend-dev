import { Component, OnInit } from '@angular/core';
import {LayoutService} from "../layout.service";

@Component({
  selector: 'sa-ribbon',
  templateUrl: './ribbon.component.html'
})
export class RibbonComponent implements OnInit {

  constructor(private layoutService: LayoutService) {}

  ngOnInit() {
  }

  resetWidgets() {
    this.layoutService.factoryReset()
  }

}
