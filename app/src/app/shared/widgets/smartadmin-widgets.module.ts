import {NgModule} from "@angular/core";
import {WidgetComponent} from "./widget/widget.component";
import {WidgetsGridComponent} from "./widgets-grid/widgets-grid.component";
import {CommonModule} from "@angular/common";

@NgModule({
  imports: [CommonModule],
  declarations: [WidgetComponent, WidgetsGridComponent],
  exports: [WidgetComponent, WidgetsGridComponent]
})
export class SmartadminWidgetsModule{}
