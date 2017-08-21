using Domain.Interfaces.Repositories;
using System;
using System.Linq;
using System.Linq.Expressions;

namespace Repository.Repositories
{
    public class Repository<T> : IRepository<T> where T : class
    {
        public void Add(T obj)
        {
            throw new NotImplementedException();
        }

        public void Update(T obj)
        {
            throw new NotImplementedException();
        }

        public bool Remove(T obj)
        {
            throw new NotImplementedException();
        }

        public IQueryable<T> Paginate(IQueryable<T> content, int page, int pageSize, Expression<Func<T, bool>> search)
        {
            if (search != null)
            {
                content = content.Where<T>(search);
            }

            return content.Skip((page - 1) * pageSize).Take(pageSize);
        }

        public void Dispose()
        {
        }
    }
}
