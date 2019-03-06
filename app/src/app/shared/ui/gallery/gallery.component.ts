import {
  Component, OnInit, Input, EventEmitter, Output
} from '@angular/core';

import {
  animate, transition, style, state,
  trigger
} from '@angular/animations';


@Component({
  selector: 'sa-gallery',
  styles: [`
    .superbox-show.active{
  display: block !important;
    }

`],
  template: `
    <div class="superbox">
      <div  >      
          <ng-template ngFor let-item="$implicit" [ngForOf]="pictures"><!--
          --><div  
             [@slideToggle]="item.state"
           class="superbox-list" (click)="activate(item)">
              <img [src]="item.src" [alt]="item.alt" [title]="item.title" class="superbox-img"/>
             </div><!--
          --><div class="superbox-show" [class.active]="item.active" [@viewportToggle]="item.state">
              <img src="{{item.img}}" *ngIf="item.active" [@fadeToggle]="item.state" class="superbox-current-img">
              <div id="imgInfoBox" class="superbox-imageinfo inline-block">
                <h1>{{item.title}}</h1><span>
                <p><em>{{item.img}}</em></p>
                <p class="superbox-img-description">{{item.alt}}</p>
                <p>
                  <a (click)="editPicture(item)" class="btn btn-primary btn-sm">Edit Image</a> 
                  <a (click)="deletePicture(item)" class="btn btn-danger btn-sm">Delete</a>
                  </p></span> 
              </div>
             
              <div class="superbox-close txt-color-white" (click)="deactivate(item)"><i class="fa fa-times fa-lg"></i></div>
            </div
            ></ng-template>
        <div class="superbox-float" ></div>
      </div>
    </div>
  `,
  animations: [
    trigger('slideToggle', [
      state('out', style({
        backgroundColor: '#eee',
      })),
      state('in', style({
        backgroundColor: '#cfd8dc',
      })),
      transition('out => in', animate('100ms ease-in')),
      transition('in => out', animate('100ms ease-out'))
    ]),
    trigger('viewportToggle', [
      state('out', style({
        height: 0,
      })),
      state('in', style({
        height: '*',
      })),
      state('stay', style({
        height: '*',
      })),
      transition('out => in', [
        style({
          display: 'block'
        }),
        animate('250ms ease-out')
      ]),
      transition('in => stay', [
        animate('0ms ease-out')
      ]),
      transition('* => out',
        animate('250ms ease-in ')
      )
    ]),
    trigger('fadeToggle', [
      state('out', style({
        opacity: 0,
      })),
      state('in', style({
        opacity: 1,
      })),
      state('stay', style({
        opacity: 1,
      })),
      transition('out <=> *', [
        animate('250ms 250ms ease-out')
      ]),
    ]),
  ],
})
export class GalleryComponent implements OnInit {

  @Input() pictures: Array<any>;


  public current: any;

  activate(picture) {

    this.pictures.filter(it => it.active && it != picture).map(this.deactivate)

    if (picture.active) {
      this.deactivate(picture)
      this.current = null
    } else {
      picture.active = true;
      picture.state = this.current ? 'stay' : 'in';
      this.current = picture
    }


  }

  deactivate(picture) {
    picture.active = false;
    picture.state = 'out';

  }

  @Output() deleteRequest = new EventEmitter();
  @Output() editRequest = new EventEmitter();

  deletePicture(picture) {
    this.deleteRequest.emit(picture);
  }

  editPicture(picture) {
    this.editRequest.emit(picture);
  }


  constructor() {
  }

  ngOnInit() {
    this.pictures.forEach((it) => {
      it.active = false;
      it.state = 'out'
    })
  }

}
