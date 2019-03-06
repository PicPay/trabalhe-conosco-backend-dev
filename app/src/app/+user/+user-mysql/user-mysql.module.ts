import { NgModule } from '@angular/core'
import { CommonModule } from '@angular/common'

import { UserMysqlRoutingModule } from './user-mysql-routing.module'
import { UserMysqlComponent } from './user-mysql.component'
import { SmartadminModule } from "../../shared/smartadmin.module"
import { SmartadminInputModule } from "../../shared/forms/input/smartadmin-input.module"
import { SmartadminDatatableModule } from "../../shared/ui/datatable/smartadmin-datatable.module"

@NgModule({
  imports: [
    CommonModule,
    UserMysqlRoutingModule,
    SmartadminModule,
    SmartadminInputModule,
    SmartadminDatatableModule
  ],
  declarations: [ UserMysqlComponent ]
})
export class UserMysqlModule { }
