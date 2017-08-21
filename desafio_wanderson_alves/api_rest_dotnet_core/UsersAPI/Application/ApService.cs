using Application.Interfaces;
using Domain.Interfaces.Repositories;
using System;
using System.Linq;

namespace Application
{
    public class ApService<T> : IApService<T> where T : class
    {
        private readonly IRepository<T> _repository;
        private readonly ICache<T> _cache;

        public ApService(IRepository<T> repository, ICache<T> cache)
        {
            this._repository = repository;
            this._cache = cache;
        }

        public void Add(T obj)
        {
            this._repository.Add(obj);
        }

        public void Update(T obj)
        {
            this._repository.Update(obj);
        }

        public bool Remove(T obj)
        {
            return this._repository.Remove(obj);
        }

        public IQueryable<T> Paginate(IQueryable<T> content, int page, int pageSize)
        {
            return this._repository.Paginate(content, page, pageSize);
        }

        public void SetCache()
        {
            this._cache.Set();
        }

        public void Dispose()
        {
            throw new NotImplementedException();
        }
    }
}
