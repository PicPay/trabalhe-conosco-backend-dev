import {Directive, OnInit, ElementRef, Input} from '@angular/core';

declare var $:any;

@Directive({
  selector: '[saJquiSlider]'
})
export class JquiSlider implements OnInit {

  @Input() saJquiSlider: any;

  constructor(private el: ElementRef) {
  }

  ngOnInit() {
    $(this.el.nativeElement).slider(this.saJquiSlider || {})

  }

}
