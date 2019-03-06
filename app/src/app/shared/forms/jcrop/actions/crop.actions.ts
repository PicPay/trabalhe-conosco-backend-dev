import {Injectable} from "@angular/core";
import {NgRedux} from "@angular-redux/store";
import {OptionsActions} from "./options.actions";


/**
 * Action creators in Angular 2. We may as well adopt a more
 * class-based approach to satisfy Angular 2's OOP idiom. It
 * has the advantage of letting us use the dependency injector
 * as a replacement for redux-thunk.
 */
@Injectable()
export class CropActions {
  constructor(private ngRedux: NgRedux<any>) {
  }

  static CROP_SELECT: string = 'CROP_SELECT';
  static CROP_CHANGE: string = 'CROP_CHANGE';
  static CROP_FIELD_CHANGE: string = 'CROP_FIELD_CHANGE';
  static CROP_RANDOM_SELECTION: string = 'CROP_RANDOM_SELECTION';

  cropSelect(crop, storeId) {
    this.ngRedux.dispatch({
        type: CropActions.CROP_SELECT,
        crop,
        storeId
      }
    )
  }
  cropChange(crop, storeId) {
    this.ngRedux.dispatch({
        type: CropActions.CROP_CHANGE,
        crop,
        storeId
      }
    )
  }

  cropFieldChange(field, value, storeId) {
    this.ngRedux.dispatch({
      type: CropActions.CROP_FIELD_CHANGE,
      field,
      value: parseInt(value),
      storeId
    })
  }

  cropRandomSelection(storeId) {
    this.ngRedux.dispatch({
      type: CropActions.CROP_RANDOM_SELECTION,
      crop: this.randomSelection(),
      storeId
    })
  }

  randomSelection() {
    let x = Math.round(Math.random() * 250);
    let y = Math.round(Math.random() * 180);

    return {
      x: x,
      y: y,
      x2: x + Math.round((Math.random() * 200) + 50 ),
      y2: y + Math.round((Math.random() * 300) + 60)
    }
  }

}
