using System;
using System.Linq;

namespace Application.Interfaces
{
    public interface IApService<T> : IDisposable where T : class
    {
        void Add(T obj);
        void Update(T obj);
        bool Remove(T obj);
        IQueryable<T> Paginate(int page = 1, int pageSize = 1, string search = "");
        void SetCache();
    }
}
