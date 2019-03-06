import {Directive, Input, ElementRef, OnInit} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[saColorpicker]'
})
export class ColorpickerDirective implements OnInit{

  @Input() saColorpicker: any;
  constructor(private el: ElementRef) {}


  ngOnInit(){
    System.import('bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js').then(()=>{
      this.render()
    })
  }

  render(){
    $(this.el.nativeElement).colorpicker(this.saColorpicker || {})
  }

}
