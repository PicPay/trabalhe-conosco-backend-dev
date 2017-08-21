import { UserAppPage } from './app.po';

describe('user-app App', () => {
  let page: UserAppPage;

  beforeEach(() => {
    page = new UserAppPage();
  });

  it('should display welcome message', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('Welcome to app!!');
  });
});
