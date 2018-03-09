import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {HomeComponent} from './home/home.component';
import {NotFoundComponent} from './shared/layout/not-found.component';

const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'auth', loadChildren: 'app/auth/auth.module#AuthModule'},
  {path: 'users', loadChildren: 'app/users/users.module#UsersModule'},
  {path: '**', component: NotFoundComponent}
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes)
  ],
  exports: [
    RouterModule
  ],
  declarations: []
})
export class AppRoutingModule {
}
