import { Component, OnInit } from '@angular/core';
import {FadeZoomInTop} from "../../animations/fade-zoom-in-top.decorator";

@FadeZoomInTop()
@Component({
  selector: 'app-empty-layout',
  templateUrl: './empty-layout.component.html',
  styles: []
})
export class EmptyLayoutComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
