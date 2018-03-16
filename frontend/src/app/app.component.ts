import {Component, OnInit} from '@angular/core';
import {UserService} from "./shared/services/user.service";

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
})
export class AppComponent implements OnInit {

    constructor(private userService: UserService) {
    }

    ngOnInit(): void {
        this.userService.populate();
    }
}
