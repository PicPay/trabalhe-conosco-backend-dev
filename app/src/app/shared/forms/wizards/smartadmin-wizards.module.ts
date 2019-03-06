import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FuelUxWizardComponent} from "./fuel-ux-wizard.component";

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [FuelUxWizardComponent],
  exports: [FuelUxWizardComponent]
})
export class SmartadminWizardsModule { }
