import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {UiValidateDirective} from "./ui-validate.directive";
import {BootstrapValidatorDirective} from "./bootstrap-validator.directive";

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [
    UiValidateDirective,
    BootstrapValidatorDirective
  ],
  exports: [
    UiValidateDirective,
    BootstrapValidatorDirective
  ]
})
export class SmartadminValidationModule { }
