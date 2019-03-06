import {Directive, ElementRef, OnInit} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[smartTags]'
})
export class SmartTagsDirective implements OnInit{

  constructor(private el : ElementRef) { }

  ngOnInit(){
    System.import('script-loader!bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js').then(()=>{
      this.render()
    })
  }


  render(){
    $(this.el.nativeElement).tagsinput();
  }


}
