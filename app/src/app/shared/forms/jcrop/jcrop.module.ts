import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FieldComponent } from './components/field.component';
import { FieldsComponent } from './components/fields.component';
import { JcropComponent } from './components/jcrop.component';
import {CropActions} from "./actions/crop.actions";
import { OptionRadioComponent } from './components/option-radio.component';
import { OptionToggleComponent } from './components/option-toggle.component';
import {OptionsActions} from "./actions/options.actions";
import {FormsModule} from "@angular/forms";
import { JcropPreviewComponent } from './components/jcrop-preview.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule
  ],
  declarations: [FieldComponent, FieldsComponent, JcropComponent,
    OptionRadioComponent, OptionToggleComponent, JcropPreviewComponent],
  exports: [FieldComponent, FieldsComponent, JcropComponent,
    OptionRadioComponent, OptionToggleComponent, JcropPreviewComponent],
  providers: [CropActions, OptionsActions]
})
export class JcropModule { }
