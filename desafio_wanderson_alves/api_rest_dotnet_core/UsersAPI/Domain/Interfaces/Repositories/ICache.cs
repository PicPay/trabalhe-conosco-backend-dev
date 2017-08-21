using System.Collections.Generic;
using System.Linq;

namespace Domain.Interfaces.Repositories
{
    public interface ICache<T>
    {
        void Set();
        void Set(T obj);
        bool Remove(T obj);
        void Clear();
        T Get(T obj);
        IQueryable<T> GetAll();
        List<string> GetAllRel01();
        List<string> GetAllRel02();
    }
}
