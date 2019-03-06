import {Directive, OnInit, ElementRef, Input} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[saUiSpinner]'
})
export class UiSpinner implements OnInit {

  @Input() saUiSpinner: any;
  constructor(private el: ElementRef) { }

  ngOnInit(){
    let options;
    
    if(this.saUiSpinner == 'decimal'){
      options = {
        step: 0.01,
        numberFormat: "n"
      };
    } else if (this.saUiSpinner == 'currency') {
      options = {
        min: 5,
        max: 2500,
        step: 25,
        start: 1000,
        numberFormat: "C"
      };
    }

    $(this.el.nativeElement).spinner((options || this.saUiSpinner) || {} );
    
  }

}
