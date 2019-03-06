import { NgModule } from '@angular/core'
import { ModuleWithProviders } from "@angular/core"
import { Routes, RouterModule } from '@angular/router'
import { UserMysqlComponent } from "./user-mysql.component"

export const routes: Routes = [  {
  path: '',
  component: UserMysqlComponent
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class UserMysqlRoutingModule { }
