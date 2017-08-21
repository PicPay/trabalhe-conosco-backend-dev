using Application.Interfaces;
using Domain.Entities;
using Domain.Interfaces.Repositories;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Linq.Expressions;

namespace Application
{
    public class UserApService : IUserApService
    {
        private readonly IRepository<User> _repository;
        private readonly ICache<User> _cache;

        public UserApService(IRepository<User> repository, ICache<User> cache)
        {
            this._repository = repository;
            this._cache = cache;
        }

        public void Add(User user)
        {
            this._repository.Add(user);
        }

        public void Update(User user)
        {
            this._repository.Update(user);
        }

        public bool Remove(User user)
        {
            return this._repository.Remove(user);
        }

        public IQueryable<User> Paginate(int page = 1, int pageSize = 1, string search = "")
        {
            IQueryable<User> content = this._cache.GetAll();
            var query = this._repository.Paginate(content, page, pageSize, string.IsNullOrWhiteSpace(search) ? null : SearchNameOrUserName(search));
            return PriorityList(query);
        }

        public void SetCache()
        {
            this._cache.Set();
        }

        public void Dispose()
        {
        }

        public Expression<Func<User, bool>> SearchNameOrUserName(string search = "")
        {
            return (x => x.Name.Contains(search) || x.UserName.Contains(search));
        }

        private IQueryable<User> PriorityList(IQueryable<User> content)
        {
            var list = new List<User>();

            var real01 = this._cache.GetAllRel01();
            var real02 = this._cache.GetAllRel02();

            if (real01.Count == 0 && real02.Count == 0)
            {
                return content;
            }

            var priority01 = from user in content
                             where real01.Contains(user.ID.ToString().Trim().ToUpper())
                             select user;

            var priority02 = from user in content
                             where real02.Contains(user.ID.ToString().Trim().ToUpper())
                             select user;

            var priority03 = from user in content
                             where !real01.Contains(user.ID.ToString().Trim().ToUpper()) && !real02.Contains(user.ID.ToString().Trim().ToUpper())
                             select user;

            if (priority01 != null)
            {
                list.AddRange(priority01.ToList<User>());
            }
            if (priority02 != null)
            {
                list.AddRange(priority02.ToList<User>());
            }
            if (priority03 != null)
            {
                list.AddRange(priority03.ToList<User>());
            }
            IQueryable<User> query = list.AsQueryable<User>();

            return query;
        }
    }
}
