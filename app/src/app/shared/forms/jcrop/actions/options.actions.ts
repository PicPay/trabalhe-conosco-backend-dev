import {Injectable} from "@angular/core";
import {NgRedux} from "@angular-redux/store";


/**
 * Action creators in Angular 2. We may as well adopt a more
 * class-based approach to satisfy Angular 2's OOP idiom. It
 * has the advantage of letting us use the dependency injector
 * as a replacement for redux-thunk.
 */
@Injectable()
export class OptionsActions {
  constructor(private ngRedux: NgRedux<any>) {
  }

  static TOGGLE_OPTION: string = 'TOGGLE_OPTION';
  static SET_OPTIONS: string = 'SET_OPTIONS';

  toggleOption(update) {
    this.ngRedux.dispatch({
        type: OptionsActions.TOGGLE_OPTION,
        option: update.option,
        storeId: update.storeId
      }
    )
  }

  setOptions(update) {
    this.ngRedux.dispatch({
      type: OptionsActions.SET_OPTIONS,
      options: update.options,
      storeId: update.storeId
    })
  }

}
