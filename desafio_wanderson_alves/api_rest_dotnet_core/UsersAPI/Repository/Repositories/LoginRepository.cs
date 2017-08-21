using Domain.Entities;
using Domain.Interfaces.Repositories;
using System;
using System.Linq;

namespace Repository.Repositories
{
    public class LoginRepository : ILoginRepository
    {
        private readonly ICache<User> _cache;

        public LoginRepository(ICache<User> cache)
        {
            this._cache = cache;
        }

        public string Login(string userName)
        {
            var count = this._cache.GetAll().Count
                (
                u => u.UserName.Trim().ToUpper().Equals(userName.Trim().ToUpper())
                );

            if (count > 0)
            {
                return Guid.NewGuid().ToString();
            }

            return "";
        }
    }
}
