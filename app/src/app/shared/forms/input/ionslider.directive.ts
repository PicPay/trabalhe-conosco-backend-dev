import {Directive, ElementRef, OnInit} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[ionSlider]'
})
export class IonSliderDirective implements OnInit{

  constructor(private el: ElementRef) { }

  ngOnInit(){
    System.import('script-loader!ion-rangeslider/js/ion.rangeSlider.min.js').then(()=>{
      this.render()
    })
  }


  render(){
    $(this.el.nativeElement).ionRangeSlider();
  }

}
