import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DygraphComponent } from './dygraph.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [DygraphComponent],
  exports: [DygraphComponent],
})
export class DygraphModule { }
