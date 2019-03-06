import {
  Injectable, ViewContainerRef, EventEmitter, ComponentFactoryResolver,
  ApplicationRef
} from '@angular/core';

import {config} from '../smartadmin.config';
import {CommandsHelpComponent} from "./commands-help.component";
import {SoundService} from "../sound/sound.service";
import {SpeechRecognition} from "./speech-recognition.api";
import {VoiceRecognitionService} from "./voice-recognition.service";
import {NotificationService} from "../utils/notification.service";
import {BodyService} from "../utils/body.service";
import {Router} from "@angular/router";
import {LayoutService} from "../layout/layout.service";


@Injectable()
export class VoiceControlService {

  public state = {
    enabled: !!config.voice_command,
    available: false,
    autoStart: !!config.voice_command_auto,
    localStorage: !!config.voice_localStorage,
    lang: config.voice_command_lang,

    started: false,
  };

  public helpShown = new EventEmitter();

  private static helpModal;

  constructor(private componentFactoryResolver: ComponentFactoryResolver,
              private app: ApplicationRef,
              private soundService: SoundService,
              private voiceRecognitionService: VoiceRecognitionService,
              private notificationService: NotificationService,
              private bodyService: BodyService,
              private router: Router,
              private layoutService: LayoutService,) {

    this.state.available = !!SpeechRecognition;

    if (config.voice_command_auto) {
      this.voiceControlOn()
    }


    this.voiceRecognitionService.events.subscribe((event)=> {
      switch (event.type) {
        case 'start':
          this.bodyService.removeClass("service-not-allowed");
          this.bodyService.addClass("service-allowed");
          break;
        case 'error':
          this.bodyService.removeClass("service-allowed");
          this.bodyService.addClass("service-not-allowed");
          break;
        case 'match':
          this.notificationService.smallBox({
            title: event.payload,
            content: "loading...",
            color: "#333",
            sound_file: 'voice_alert',
            timeout: 2000
          });
          break;
        case 'no match':
          this.notificationService.smallBox({
            title: "Error: <strong>" + ' " ' + event.payload + ' " ' + "</strong> no match found!",
            content: "Please speak clearly into the microphone",
            color: "#a90329",
            timeout: 5000,
            icon: "fa fa-microphone"
          });
          break;

        case 'action':
          this.respondToAction(event);
          break
      }
    })
  }


  public attachHelp(){
    if (this.state.available && !VoiceControlService.helpModal) {

      const component = this.componentFactoryResolver.resolveComponentFactory(CommandsHelpComponent);
      const viewContainerRef: ViewContainerRef = this.app['_rootComponents'][0]._component.viewContainerRef;

      VoiceControlService.helpModal = viewContainerRef.createComponent(component, viewContainerRef.length);
    }
  }

  public showHelp() {
    setTimeout(()=> {
      // debugger

      VoiceControlService.helpModal._component.show();
      this.helpShown.next(true);
    }, 50);

  }

  public hideHelp() {
    VoiceControlService.helpModal && VoiceControlService.helpModal._component.hide()
  }


  public voiceControlOn() {
    this.soundService.play('voice_on');
    if (!this.voiceRecognitionService.commandsList.length) {
      this.voiceRecognitionService.addCommands(config.voice_commands)
    }
    this.voiceRecognitionService.start();
    this.state.started = true;

    this.bodyService.addClass('voice-command-active');
  }

  public voiceControlOff() {
    this.soundService.play('voice_off');
    this.voiceRecognitionService.abort();
    this.state.started = false;
    this.bodyService.removeClass('voice-command-active');
  }

  public respondToAction(action) {
    switch (action.actionType) {
      case 'voice':
        switch (action.payload) {
          case 'help on':
            this.showHelp();
            break;
          case 'help off':
            this.hideHelp();
            break;
          case 'stop':
            this.voiceControlOff();
            this.notificationService.smallBox({
              title: "VOICE COMMAND OFF",
              content: "Your voice commands has been successfully turned off. Click on the <i class='fa fa-microphone fa-lg fa-fw'></i> icon to turn it back on.",
              color: "#40ac2b",
              sound_file: 'voice_off',
              timeout: 8000,
              icon: "fa fa-microphone-slash"
            });
            break;
        }
        break;
      case 'navigate':
        this.router.navigate(action.payload);
        break;
      case 'layout':
        switch (action.payload) {
          case 'show navigation':
            this.layoutService.onCollapseMenu(false);
            break;
          case 'hide navigation':
            this.layoutService.onCollapseMenu(true);
            break;
        }
        break;
      case 'sound':
        switch (action.payload) {
          case 'mute':
            this.soundService.mute();
            break;
          case 'sound on':
            this.soundService.soundOn();
            break;
        }
        break;
    }

  }


}
