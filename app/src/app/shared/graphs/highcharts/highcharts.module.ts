import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {HighchartTable} from "./highchart-table.directive";

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [HighchartTable],
  exports: [HighchartTable]
})
export class HighchartsModule { }
