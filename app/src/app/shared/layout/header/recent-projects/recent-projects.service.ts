import {Injectable} from '@angular/core';

@Injectable()
export class RecentProjectsService {
  projects:any;

  constructor() {
    this.projects = [
      {
        "href": "/",
        "title": "Online e-merchant management system - attaching integration with the iOS"
      },
      {
        "href": "/",
        "title": "Notes on pipeline upgradee"
      },
      {
        "href": "/",
        "title": "Assesment Report for merchant account"
      }
    ]

  }

  getProjects() {
    return this.projects
  }

  clearProjects() {
    this.projects = []
  }

}
