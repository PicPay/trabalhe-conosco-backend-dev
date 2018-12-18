using ApiRestfullpic.Model;
using System.Collections.Generic;
using Tapioca.HATEOAS.Utils;

namespace ApiRestfullpic.Business
{
    public interface IUserBusiness
    {
        T FindById(long id);
        T FindByGuid(string guid);
        List<T> FindByKeyWord(string keyword);
        PagedSearchDTO<T> FindByKeyWordPaged(string keyword, string sortDirection, int pageSize, int page);
        
    }
}
