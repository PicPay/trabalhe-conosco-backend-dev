import {Directive, ElementRef, OnInit, Input} from '@angular/core';

declare var $: any;


$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
  _title: function(title) {
    if (!this.options.title ) {
      title.html("&#160;");
    } else {
      title.html(this.options.title);
    }
  }
}));

@Directive({
  selector: '[saJquiDialog]'
})
export class JquiDialog implements OnInit {


  @Input() saJquiDialog: any;

  constructor(private el: ElementRef) {
  }


  ngOnInit(){

    $(this.el.nativeElement).dialog(this.saJquiDialog)
  }
}
