import {Directive, HostListener, ElementRef, Input} from '@angular/core';


declare var $: any;

/*$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
  _title: function (title) {
    if (!this.options.title) {
      title.html("&#160;");
    } else {
      title.html(this.options.title);
    }
  }
}));*/

@Directive({
  selector: '[saJquiDialogLauncher]'
})
export class JquiDialogLauncher {
  @Input() saJquiDialogLauncher: any;

  @HostListener('click', ['$event']) onClick(e) {
    $( this.saJquiDialogLauncher ).dialog( "open" );
  }

  constructor(private el: ElementRef) { }

}
