import {Component, OnInit, Input, OnDestroy, ViewChild} from '@angular/core';
import {CropActions} from "../actions/crop.actions";
import {NgRedux} from "@angular-redux/store";

import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/skipWhile';
import {OptionsActions} from "../actions/options.actions";


require('jquery-jcrop/js/jquery.Jcrop.min.js');

const debounce = require('debounce');

@Component({
  selector: 'jcrop',
  template: `
    <div #jcropContainer [ngStyle]="{
      width: width + 'px',
      height: height + 'px'
    }">
        <img #jcropImage [src]="src" [width]="width" [height]="height" />
    </div>
  `,

})
export class JcropComponent implements OnInit, OnDestroy {

  @Input() src: string;
  @Input() width: number;
  @Input() height: number;
  @Input() storeId: any;


  @ViewChild('jcropImage') jcropImage;
  @ViewChild('jcropContainer') jcropContainer;

  @Input() options: any;

  private api: any;

  private lastOptions: any = {};
  private optionsSub: any;

  private lastCrop: any = {};
  private cropSub: any;
  private isMoving: boolean = false;
  private isActive: boolean = false;

  constructor(private ngRedux: NgRedux<any>,
              private cropActions: CropActions,
              private optionsActions: OptionsActions,) {
  }

  ngOnInit() {

    let self = this;


    this.optionsSub = this.ngRedux.select([this.storeId, 'options'])

      .subscribe((options: any) => {
        if (!this.api) return;

        let updates = Object.keys(options).reduce((_updates, key)=> {
          if (this.lastOptions[key] != options[key]) {
            _updates[key] = options[key]
          }
          return _updates
        }, {});

        if (options.setImage) {
          options.src = options.setImage;
          self.api.disable();

          self.api.setImage(options.setImage);
          self.api.enable();
        }

        if (Object.keys(updates).length) {
          self.api.setOptions(updates);
          self.api.focus();
        }


        self.lastOptions = Object.assign({}, options)


      });


    this.cropSub = this.ngRedux.select([this.storeId, 'crop', 'selection']).skipWhile(() => {
      return self.isMoving
    }).subscribe((crop: any)=> {
      if (!self.api) return;

      let options = self.ngRedux.getState()[self.storeId].options;

      let lc = self.lastCrop;


      if (
        crop &&
        crop.x &&
        crop.y &&
        crop.x2 &&
        crop.y2 && !self.isMoving &&
        (
          lc.x != crop.x ||
          lc.y != crop.y ||
          lc.x2 != crop.x2 ||
          lc.y2 != crop.y2
        )
      ) {
        self.lastCrop = Object.assign({}, crop);

        self.isMoving = true;

        if (options.animateTo) {
          self.api.animateTo([crop.x, crop.y, crop.x2, crop.y2], function () {
            self.isMoving = false
          });
        } else {
          self.api.setSelect([crop.x, crop.y, crop.x2, crop.y2]);
          self.isMoving = false
        }
      }
    });

    this.render()
  }

  render() {

    const self = this;
    const element = jQuery(this.jcropImage.nativeElement);
    const container = jQuery(this.jcropContainer.nativeElement);

    element.Jcrop({
      onChange: this.onChange,
      onSelect: this.onSelect,
      onRelease: this.onRelease,
    }, function () {
      self.api = this;



      let initializingOptions = Object.assign({}, {
        width: self.width,
        height: self.height,
        src: self.src,
      }, self.options || {})


      if(initializingOptions.setSelect){
        self.cropActions.cropSelect(initializingOptions.setSelect, self.storeId)
      } else {
        self.cropActions.cropRandomSelection(self.storeId)
      }

      self.optionsActions.setOptions({
        options: initializingOptions,
        storeId: self.storeId
      })

    });
  }

  onChange = (crop)=> {
    this.cropActions.cropChange(
      crop, this.storeId
    )
  };

  onSelect = (crop)=> {
    this.cropActions.cropSelect(
      crop, this.storeId
    )
  };
  onRelease = (crop)=> {
    this.isActive = false;
  };

  ngOnDestroy() {
    this.optionsSub.unsubscribe();
    this.cropSub.unsubscribe();
  }

}
