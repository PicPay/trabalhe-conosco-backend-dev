import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {SmartProgressbarModule} from "./smart-progressbar/smart-progressbar.module";
import {TreeViewModule} from "./tree-view/tree-view.module";
import {JqueryUiModule} from "./jquery-ui/jquery-ui.module";
import {NestableListModule} from "./nestable-list/nestable-list.module";

@NgModule({
  imports: [CommonModule],

  exports: [SmartProgressbarModule, JqueryUiModule, NestableListModule, TreeViewModule],
})
export class SmartadminUiModule{}
