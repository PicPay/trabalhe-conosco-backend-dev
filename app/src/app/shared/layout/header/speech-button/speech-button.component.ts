import {Component, OnInit, ViewChild} from '@angular/core';
import {VoiceControlService} from "../../../voice-control/voice-control.service";
import {VoiceRecognitionService} from "../../../voice-control/voice-recognition.service";



@Component({
  selector: 'sa-speech-button',
  templateUrl: './speech-button.component.html',
  styles: [`.vc-title-error {display: block;}`]
})
export class SpeechButtonComponent implements OnInit {

  @ViewChild('speechPopover') speechPopover;

  public hasError: boolean = false;

  public enabled: boolean = false;

  public speechPopoverShown: boolean = false;

  constructor(private voiceControlService: VoiceControlService,
              private voiceRecognitionService: VoiceRecognitionService) {
    this.enabled = this.voiceControlService.state.enabled && this.voiceControlService.state.available;

    this.voiceRecognitionService.events.delay(50).subscribe((event)=> {
      this.respondTo(event)
    });

    this.voiceControlService.helpShown.delay(50).subscribe(()=> {
      if (this.speechPopoverShown) {
        this.speechPopover.hide();
      }
    })
  }

  ngOnInit() {
    this.voiceControlService.attachHelp()
  }

  seeCommands() {
    this.voiceControlService.showHelp()
  }

  toggleVoiceControl() {
    this.speechPopoverShown = !this.speechPopoverShown;

    if (!this.voiceControlService.state.started) {
      this.voiceControlService.voiceControlOn();
    } else {
      this.voiceControlService.voiceControlOff();
    }
  }

  private respondTo(event) {
    switch (event.type) {
      case 'start':
        this.hasError = false;
        break;
      case 'error':
        this.hasError = true;
        break;

      case 'match':
      case 'no match':
        if (this.speechPopoverShown) {
          this.speechPopover.hide();
        }
        break
    }

  }
}
