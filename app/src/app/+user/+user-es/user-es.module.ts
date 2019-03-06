import { NgModule } from '@angular/core'
import { CommonModule } from '@angular/common'

import { UserEsRoutingModule } from './user-es-routing.module'
import { UserEsComponent } from './user-es.component'
import { SmartadminModule } from "../../shared/smartadmin.module"
import { SmartadminInputModule } from "../../shared/forms/input/smartadmin-input.module"
import { SmartadminDatatableModule } from "../../shared/ui/datatable/smartadmin-datatable.module"

@NgModule({
  imports: [
    CommonModule,
    UserEsRoutingModule,
    SmartadminModule,
    SmartadminInputModule,
    SmartadminDatatableModule
  ],
  declarations: [ UserEsComponent ]
})
export class UserEsModule { }
