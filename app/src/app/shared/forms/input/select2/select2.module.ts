import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {Select2Directive} from "./select2.directive";


@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [Select2Directive],
  exports: [Select2Directive],
})
export class Select2Module { }
