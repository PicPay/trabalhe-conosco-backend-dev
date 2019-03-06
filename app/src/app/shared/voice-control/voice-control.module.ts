import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {ModalModule} from "ngx-bootstrap";

import {SoundModule} from "../sound/sound.module";
import {UtilsModule} from "../utils/utils.module";

import {VoiceControlService} from "./voice-control.service";
import {CommandsHelpComponent} from './commands-help.component';
import {VoiceRecognitionService} from "./voice-recognition.service";


@NgModule({
  imports: [
    CommonModule, ModalModule, SoundModule, UtilsModule
  ],
  exports: [CommandsHelpComponent],
  declarations: [CommandsHelpComponent],
  providers: [VoiceControlService, VoiceRecognitionService],
  entryComponents: [CommandsHelpComponent]

})
export class VoiceControlModule {
  static forRoot() {
    return {
      ngModule: VoiceControlModule,
      providers: [VoiceControlService, VoiceRecognitionService]
    }
  }
}
