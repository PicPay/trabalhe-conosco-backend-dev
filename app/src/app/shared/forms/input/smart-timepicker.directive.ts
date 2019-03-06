import {Directive, ElementRef, OnInit} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[smartTimepicker]'
})
export class SmartTimepickerDirective implements OnInit{

  constructor(private el: ElementRef) { }

  ngOnInit(){
    System.import('script-loader!bootstrap-timepicker/js/bootstrap-timepicker.min.js').then(()=>{
      this.render()
    })
  }


  render(){
    $(this.el.nativeElement).timepicker();
  }
}
