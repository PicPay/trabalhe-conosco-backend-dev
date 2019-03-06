import {Component, OnInit, Input} from '@angular/core';

@Component({
  selector: '[activitiesTask]',
  templateUrl: './activities-task.component.html',
})
export class ActivitiesTaskComponent implements OnInit {

  @Input() item: any;
  @Input() lastUpdate: any;

  constructor() {}

  ngOnInit() {
  }

  setProgressClasses(){
    return {
      'progress-bar': true,
      'progress-bar-success': this.item.status == 'MINOR' || this.item.status == 'NORMAL',
      'bg-color-teal': this.item.status == 'PRIMARY' || this.item.status == 'URGENT',
      'progress-bar-danger': this.item.status == 'CRITICAL'
    };
  }
}
