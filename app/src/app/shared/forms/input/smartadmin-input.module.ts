import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import {ColorpickerDirective} from './colorpicker.directive';
import {FileInputComponent} from './file-input/file-input.component';
import {KnobDirective} from './knob.directive';
import {MaskedInput} from './masked-input.directive';
import {UiDatepickerDirective} from './ui-datepicker.directive';
import {UiSpinner} from './ui-spinner.directive';
import {XEditableComponent} from './x-editable.component';
import {DuallistboxComponent} from './duallistbox.component';
import {NouisliderDirective} from './nouislider.directive'
import {IonSliderDirective} from './ionslider.directive'
import {SmartSliderDirective} from './smart-slider.directive'
import {SmartTagsDirective} from './smart-tags.directive'
import {SmartTimepickerDirective} from './smart-timepicker.directive'
import {SmartClockpickerDirective} from './smart-clockpicker.directive'
import {Select2Module} from "./select2/select2.module";
import {OnOffSwitchModule} from "./on-off-switch/on-off-switch.module";

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [

    ColorpickerDirective,
    FileInputComponent,
    KnobDirective,
    MaskedInput,
    UiDatepickerDirective,
    UiSpinner,
    XEditableComponent,
    DuallistboxComponent,
    NouisliderDirective,
    IonSliderDirective,
    SmartSliderDirective,
    SmartTagsDirective,
    SmartTimepickerDirective,
    SmartClockpickerDirective,

  ],
  exports: [

    ColorpickerDirective,
    FileInputComponent,
    KnobDirective,
    MaskedInput,
    UiDatepickerDirective,
    UiSpinner,
    XEditableComponent,
    DuallistboxComponent,
    NouisliderDirective,
    IonSliderDirective,
    SmartSliderDirective,
    SmartTagsDirective,
    SmartTimepickerDirective,
    SmartClockpickerDirective,


    Select2Module,
    OnOffSwitchModule,
  ]
})
export class SmartadminInputModule { }
