import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {UsersListComponent} from './users-list/users-list.component';
import {AuthGuard} from '../shared/services/auth.guard';

const routes: Routes = [
  {
    path: 'list',
    component: UsersListComponent,
    canActivate: [AuthGuard],
    canLoad: [AuthGuard]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UsersRoutingModule {
}
