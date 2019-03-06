import {Injectable} from '@angular/core';

import {config} from '../smartadmin.config';
import {NotificationService} from "../utils/notification.service";

@Injectable()
export class SoundService {

  constructor(private notificationService: NotificationService) {}

  public config = {
    basePath: config.sound_path,
    mainExt: '.mp3',
    alternateExt: '.ogg',
  };

  private static cache = {};

  get(name) {
    if (SoundService.cache[name]) {
      return Promise.resolve(SoundService.cache[name])
    } else {
      return new Promise((resolve, reject)=> {
        const audioElement = document.createElement('audio');
        if (navigator.userAgent.match('Firefox/')) {
          audioElement.setAttribute('src', this.config.basePath + name + this.config.alternateExt);
        } else {
          audioElement.setAttribute('src', this.config.basePath + name + this.config.mainExt);
        }

        audioElement.addEventListener('error', reject);

        audioElement.load();
        SoundService.cache[name] = audioElement;
        resolve(audioElement)
      })
    }
  }

  play(name) {
    if(config.sound_on){
      this.get(name).then((audio)=> {
        audio.play()
      })
    }
  }


  mute() {
    config.sound_on = false;
    this.notificationService.smallBox({
      title: "MUTE",
      content: "All sounds have been muted!",
      color: "#a90329",
      timeout: 4000,
      icon: "fa fa-volume-off"
    });
  }

  soundOn() {
    config.sound_on = true;
    this.notificationService.smallBox({
      title: "UNMUTE",
      content: "All sounds have been turned on!",
      color: "#40ac2b",
      sound_file: 'voice_alert',
      timeout: 5000,
      icon: "fa fa-volume-up"
    });
  }

}
