import {Injectable} from '@angular/core';

declare var $: any;


@Injectable()
export class BodyService {

  public $body: any;

  constructor() {
    this.$body = $('body')
  }

  addClass(className: string) {
    this.$body.addClass(className)
  }

  removeClass(className: string) {
    this.$body.removeClass(className)
  }

  toggleClass(className: string, state?: boolean) {
    this.$body.toggleClass(className, state)
  }


}
