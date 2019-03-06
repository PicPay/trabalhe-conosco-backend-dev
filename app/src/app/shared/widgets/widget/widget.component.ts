import {Component, OnInit, ElementRef, Input, AfterViewInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";

declare var $: any;

@Component({

  selector: 'sa-widget',
  template: `<div id="{{widgetId}}" class="jarviswidget"
    
  ><ng-content></ng-content></div>`
})
export class WidgetComponent implements OnInit, AfterViewInit {


  public widgetId: string;

  @Input() public name: string;
  @Input() public colorbutton: boolean = true;
  @Input() public editbutton: boolean = true;
  @Input() public togglebutton: boolean = true;
  @Input() public deletebutton: boolean = true;
  @Input() public fullscreenbutton: boolean = true;
  @Input() public custombutton: boolean = false;
  @Input() public collapsed: boolean = false;
  @Input() public sortable: boolean = true;
  @Input() public hidden: boolean = false;
  @Input() public color: string;
  @Input() public load: boolean = false;
  @Input() public refresh: boolean = false;


  static counter: number = 0;

  constructor(public el: ElementRef, private route: ActivatedRoute, private router: Router) {

  }

  ngOnInit() {
    this.widgetId = this.genId();


    let widget = this.el.nativeElement.children[0];

    if (this.sortable) {
      widget.className += ' jarviswidget-sortable';
    }

    if (this.color) {
      widget.className += (' jarviswidget-color-' + this.color);
    }

    ['colorbutton',
      'editbutton',
      'togglebutton',
      'deletebutton',
      'fullscreenbutton',
      'custombutton',
      'sortable'
    ].forEach((option) => {
      if (!this[option]) {
        widget.setAttribute('data-widget-' + option, 'false')
      }
    });

    [
      'hidden',
      'collapsed'
    ].forEach((option) => {
      if (this[option]) {
        widget.setAttribute('data-widget-' + option, 'true')
      }
    });


    // ['refresh', 'load'].forEach(function (option) {
    //   if (this[option])
    //     widgetProps['data-widget-' + option] = this[option]
    // }.bind(this));

  }

  private genId() {
    if (this.name) {
      return this.name
    } else {
      let heading = this.el.nativeElement.querySelector('header h2');
      let id = heading ? heading.textContent.trim() : 'jarviswidget-' + WidgetComponent.counter++;
      id = id.toLowerCase().replace(/\W+/gm, '-');

      let url = this.router.url.substr(1).replace(/\//g, '-');
      id = url + '--' + id;

      return id
    }

  }

  ngAfterViewInit(): any {
    const $widget = $(this.el.nativeElement);

    if (this.editbutton) {
      $widget.find('.widget-body').prepend('<div class="jarviswidget-editbox"><input class="form-control" type="text"></div>');
    }

    const isFiller = $widget.hasClass('sa-fx-col');

    if ($widget.attr('class')) {
      $widget.find('.jarviswidget').addClass($widget.attr('class'))
      $widget.attr('class', '')
    }

    if (isFiller) {
      $widget.attr('class', 'sa-fx-col')
    }
  }


}
