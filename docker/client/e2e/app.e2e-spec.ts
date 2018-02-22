import { FrameworkPage } from './app.po';

describe('framework App', function() {
  let page: FrameworkPage;

  beforeEach(() => {
    page = new FrameworkPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
