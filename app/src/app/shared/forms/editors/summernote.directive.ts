import {Directive, ElementRef, Input, OnInit, Output, EventEmitter} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[summernote]'
})
export class SummernoteDirective implements OnInit{

  @Input() summernote = {};
  @Output() change = new EventEmitter()

  constructor(private el: ElementRef) {

  }

  ngOnInit(){
    System.import('script-loader!summernote/dist/summernote.min.js').then(()=>{
      this.render()
    })
  }

  render(){
      $(this.el.nativeElement).summernote(Object.assign(this.summernote, {
        tabsize : 2,
        callbacks: {
          onChange: (we, contents, $editable) => {
            this.change.emit(contents)
          }
        }
      }))

  }

}
