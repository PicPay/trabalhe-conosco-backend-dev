import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {JquiDialogLauncher} from "./jqui-dialog/jqui-dialog-launcher.directive";
import {JquiAccordion} from "./jqui-accordion.directive";
import {JquiMenu} from "./jqui-menu.directive";
import {JquiAutocomplete} from "./jqui-autocomplete.directive";
import {JquiProgressbar} from "./jqui-progressbar.directive";
import {JquiSpinner} from "./jqui-spinner.directive";
import {JquiSlider} from "./jqui-slider.directive";
import {JquiTabs} from "./jqui-tabs.directive";
import {JquiDialog} from "./jqui-dialog/jqui-dialog.directive";

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [
    JquiDialog,
    JquiDialogLauncher,
    JquiAccordion,
    JquiMenu,
    JquiAutocomplete,
    JquiProgressbar,
    JquiSpinner,
    JquiSlider,
    JquiTabs,
  ],
  exports: [
    JquiDialog,
    JquiDialogLauncher,
    JquiAccordion,
    JquiMenu,
    JquiAutocomplete,
    JquiProgressbar,
    JquiSpinner,
    JquiSlider,
    JquiTabs,
  ]
})
export class JqueryUiModule {
}
