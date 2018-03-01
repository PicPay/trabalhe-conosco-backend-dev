import {NgModule} from '@angular/core';

import {SigninComponent} from './signin/signin.component';
import {SharedModule} from '../shared/shared.module';
import {AuthRoutingModule} from './auth-routing.module';

@NgModule({
    imports: [
        SharedModule,
        AuthRoutingModule,
    ],
    declarations: [SigninComponent]
})
export class AuthModule {
}
