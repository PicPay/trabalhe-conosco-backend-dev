import {Component, OnInit} from '@angular/core';
import {LayoutService} from "../../layout.service";

declare var $: any;

@Component({
  selector: 'sa-collapse-menu',
  templateUrl: './collapse-menu.component.html'
})
export class CollapseMenuComponent {

  constructor(
    private layoutService: LayoutService
  ) {

  }

  onToggle() {
    this.layoutService.onCollapseMenu()
  }
}
