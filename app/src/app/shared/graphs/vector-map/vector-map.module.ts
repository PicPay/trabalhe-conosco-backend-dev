import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { VectorMapComponent } from './vector-map.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [VectorMapComponent],
  exports: [VectorMapComponent],
})
export class VectorMapModule { }
