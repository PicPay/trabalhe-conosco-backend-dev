import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AuthGuard } from './guards/auth.guard';
import { LoginComponent } from './components/login/login.component';

const routes: Routes = [
  {path: 'home', loadChildren: 'app/components/home/home.module#HomeModule', canActivate:[AuthGuard]},
  {path: 'user', loadChildren: 'app/components/user/user.module#UserModule', canActivate:[AuthGuard]},
  {path: 'login', component: LoginComponent},
  { path: '', pathMatch: 'full', redirectTo: 'login' },
  { path: '**', pathMatch: 'full', redirectTo: 'login' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
