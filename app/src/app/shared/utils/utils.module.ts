import {NgModule} from "@angular/core";
import {MomentPipe} from "./moment.pipe";
import {TimeDirective} from "./time.directive";
import { FieldFilterPipe } from './field-filter.pipe';
import {BodyService} from "./body.service";
import {NotificationService} from "./notification.service";
import {ToggleActiveDirective} from "./toggle-active.directive";

@NgModule({
  declarations: [ToggleActiveDirective, MomentPipe, TimeDirective, FieldFilterPipe],
  exports: [ToggleActiveDirective, MomentPipe, TimeDirective, FieldFilterPipe],
  providers: [BodyService, NotificationService]
})
export class UtilsModule{
  static forRoot(){
    return {
      ngModule: UtilsModule,
      providers: [BodyService, NotificationService]
    }
  }
}
