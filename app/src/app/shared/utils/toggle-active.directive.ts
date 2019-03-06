import {Directive, HostBinding, Input} from '@angular/core';

@Directive({
  selector: '[saToggleActive]'
})
export class ToggleActiveDirective {

  @HostBinding('class.active') @Input() saToggleActive;

  constructor() {}

}
