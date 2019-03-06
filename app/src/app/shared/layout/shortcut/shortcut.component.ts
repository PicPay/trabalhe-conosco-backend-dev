import {Subscription} from "rxjs/Rx";
import {
  Component, OnInit, OnDestroy, ElementRef,
  Renderer, AfterViewInit, AfterContentInit
} from '@angular/core';
import { Router} from "@angular/router";

import {LayoutService} from "../layout.service";

import { trigger,
  state,
  style,
  transition,
  animate} from '@angular/animations'

@Component({
  selector: 'sa-shortcut',
  templateUrl: './shortcut.component.html',
  animations: [
    trigger('shortcutState', [
      state('out', style({
        height: 0,
      })),
      state('in', style({
        height: '*',
      })),
      transition('out => in', animate('250ms ease-out')),
      transition('in => out', animate('250ms 300ms ease-in '))
    ])
  ]
})
export class ShortcutComponent implements OnInit, AfterViewInit, AfterContentInit, OnDestroy {


  public state:string = 'out';

  private layoutSub:Subscription;
  private documentSub:any;

  constructor(private layoutService:LayoutService,
              private router:Router,
              private renderer:Renderer,
              private el:ElementRef) {
  }

  shortcutTo(route) {
    this.router.navigate(route);
    this.layoutService.onShortcutToggle(false);
  }

  ngOnInit() {

  }

  listen() {
    this.layoutSub = this.layoutService.subscribe((store)=> {
      this.state = store.shortcutOpen ? 'in' : 'out'

      if (store.shortcutOpen) {
        this.documentSub = this.renderer.listenGlobal('document', 'mouseup', (event) => {
          if (!this.el.nativeElement.contains(event.target)) {
            this.layoutService.onShortcutToggle(false);
            this.documentUnsub()
          }
        });
      } else {
        this.documentUnsub()
      }
    })
  }

  ngAfterContentInit() {
    this.listen()

  }


  ngAfterViewInit() {
  }

  ngOnDestroy() {
    this.layoutSub.unsubscribe();
  }


  documentUnsub() {
    this.documentSub && this.documentSub();
    this.documentSub = null
  }

}
