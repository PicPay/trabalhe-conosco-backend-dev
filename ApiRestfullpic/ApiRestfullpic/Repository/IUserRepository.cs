using ApiRestfullpic.Model;
using System.Collections.Generic;

namespace ApiRestfullpic.Repository
{
    public interface IUserRepository
    {
        T FindById(long id);
        T FindByGuid(string guid);
        List<T> FindByKeyWord(string keyword);
        List<T> FindByKeyWordPaged(string query);
        int GetCount(string query);
    }
}
