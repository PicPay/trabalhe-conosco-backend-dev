import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChartJsComponent } from './chart-js.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [ChartJsComponent],
  exports: [ChartJsComponent],
})
export class ChartJsModule { }
