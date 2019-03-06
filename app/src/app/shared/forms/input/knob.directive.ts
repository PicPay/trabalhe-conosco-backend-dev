import {Directive, Input, ElementRef} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[saKnob]'
})
export class KnobDirective {


  @Input() saKnob: any;
  constructor(private el: ElementRef) {
    System.import('jquery-knob').then(()=>{
      this.render()
    })
  }

  render(){
    $(this.el.nativeElement).knob(this.saKnob || {})
  }

}
