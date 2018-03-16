export interface ListResult<T> {
  items: T[];

  total: number;

  count: number;

  nbPages: number;

  _links: {
    first?: '';
    last?: '';
    next?: '';
    previous?: '';
  };
}
