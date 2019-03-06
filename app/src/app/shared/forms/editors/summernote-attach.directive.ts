import {Directive, Input, OnInit, HostListener} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[summernoteAttach]'
})
export class SummernoteAttachDirective implements OnInit{

  @Input() summernoteAttach: any;
  @HostListener('click') render(){
    $(this.summernoteAttach).summernote({
      focus: true
    })
  }

  constructor() {  }

  ngOnInit(){
    System.import('script-loader!summernote/dist/summernote.min.js')
  }
}
