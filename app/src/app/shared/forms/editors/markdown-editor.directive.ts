
import {Directive, ElementRef, OnInit, Input} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[markdownEditor]'
})
export class MarkdownEditorDirective implements OnInit {

  @Input() markdownEditor: any;

  constructor(private el:ElementRef) {
  }

  ngOnInit() {
    System.import('./markdown-editor.bundle').then(()=> {
      this.render()
    })
  }


  render() {
    $(this.el.nativeElement).markdown(this.markdownEditor || {});
  }

}
