import {Directive, OnInit, ElementRef, Input} from '@angular/core';

declare var $:any;

@Directive({
  selector: '[saJquiSpinner]'
})
export class JquiSpinner implements OnInit {

  @Input() saJquiSpinner: any;

  constructor(private el: ElementRef) {
  }

  ngOnInit() {
    $(this.el.nativeElement).spinner(this.saJquiSpinner || {})

  }

}
