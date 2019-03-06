import { NgModule } from '@angular/core'
import { ModuleWithProviders } from "@angular/core"
import { Routes, RouterModule } from '@angular/router'
import { UserEsComponent } from "./user-es.component"

export const routes: Routes = [  {
  path: '',
  component: UserEsComponent
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class UserEsRoutingModule { }
