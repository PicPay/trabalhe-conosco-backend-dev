import {Directive, Input, ElementRef, OnInit} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[saMaskedInput]'
})
export class MaskedInput implements OnInit{

  @Input() saMaskedInput: string;
  @Input() saMaskedPlaceholder: string;

  constructor(private el: ElementRef) {}

  ngOnInit(){
    System.import('script-loader!jquery.maskedinput/src/jquery.maskedinput.js').then(()=>{
      let options = this.saMaskedPlaceholder ? {placeholder: this.saMaskedPlaceholder} : '';
      $(this.el.nativeElement).mask(this.saMaskedInput, options)
    })
  }

}
