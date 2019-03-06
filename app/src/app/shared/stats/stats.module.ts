import {NgModule} from '@angular/core';
import {CommonModule} from "@angular/common";
import {StatsComponent} from "./stats.component";
import {InlineGraphsModule} from "../graphs/inline/inline-graphs.module";

@NgModule({
  imports: [CommonModule, InlineGraphsModule],
  declarations: [StatsComponent],
  exports: [StatsComponent],
})
export class StatsModule {}
