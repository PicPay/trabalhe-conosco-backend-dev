import { FrontPaginacaoPage } from './app.po';

describe('front-paginacao App', () => {
  let page: FrontPaginacaoPage;

  beforeEach(() => {
    page = new FrontPaginacaoPage();
  });

  it('should display welcome message', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('Welcome to app!');
  });
});
