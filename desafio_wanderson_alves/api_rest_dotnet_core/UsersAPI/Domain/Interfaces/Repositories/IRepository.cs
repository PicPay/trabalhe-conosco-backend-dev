using System;
using System.Linq;
using System.Linq.Expressions;

namespace Domain.Interfaces.Repositories
{
    public interface IRepository<T> : IDisposable where T : class
    {
        void Add(T obj);
        void Update(T obj);
        bool Remove(T obj);
        IQueryable<T> Paginate(IQueryable<T> content, int page, int pageSize, Expression<Func<T, bool>> search);
    }
}
