using System.Collections.Generic;
using ApiRestfullpic.Model;
using ApiRestfullpic.Repository;
using Tapioca.HATEOAS.Utils;

namespace ApiRestfullpic.Business.Implemantations
{
    public class UserBusinessImpl : IUserBusiness
    {
        protected IUserRepository _repository;
        
        public UserBusinessImpl(IUserRepository repository)
        {
            _repository = repository;

        }

        public T FindById(long id)
        {
            return _repository.FindById(id);
        }

        public T FindByGuid(string guid)
        {
            return _repository.FindByGuid(guid);
            
        }

        public List<T> FindByKeyWord(string keyword)
        {
            return _repository.FindByKeyWord(keyword);
        }

        public PagedSearchDTO<T> FindByKeyWordPaged(string keyword, string sortDirection, int pageSize, int page)
        {
            page = page > 0 ? page - 1 : 0;
            int offset = pageSize * page;
            string query = @"select * from Users u where 1 = 1 ";
            if (!string.IsNullOrEmpty(keyword)) query = query + $" and u.nome like '%{keyword}%' && u.userName like '%{keyword}%'";

            query = query + $" order by field(guid,(select id from order1 where id = u.guid),(select id from order2 where id = u.guid)) {sortDirection} limit {pageSize} offset {offset}";

            string countQuery = @"select count(*) from Users u where 1 = 1 ";
            if (!string.IsNullOrEmpty(keyword)) countQuery = countQuery + $" and u.nome like '%{keyword}%' && u.userName like '%{keyword}%'";

            var users = _repository.FindByKeyWordPaged(query);

            int totalResults = _repository.GetCount(countQuery);

            return new PagedSearchDTO<T>
            {
                CurrentPage = page + 1,
                List = users,
                PageSize = pageSize,
                SortDirections = sortDirection,
                TotalResults = totalResults
            };

        }
    }
}
