import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Errors} from '../../shared/models/errors.model';
import {UserService} from '../../shared/services/user.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
})
export class SigninComponent implements OnInit {

  errors: Errors = {errors: {}};
  isSubmitting = false;
  authForm: FormGroup;

  constructor(private fb: FormBuilder, private userService: UserService, private router: Router) {
    this.authForm = this.fb.group({
      'email': ['', Validators.required],
      'password': ['', Validators.required]
    });
  }

  ngOnInit() {
  }

  submitForm() {
    this.isSubmitting = true;
    this.errors = {errors: {}};

    const credentials = this.authForm.value;
    this.userService
      .attemptAuth(credentials)
      .subscribe(
        data => {
          this.router.navigateByUrl('/');
        },
        err => {
          console.log(err);
          this.errors = {errors: {'': 'Usuário ou senha inválidos'}};
          this.isSubmitting = false;
        }
      );
  }
}
