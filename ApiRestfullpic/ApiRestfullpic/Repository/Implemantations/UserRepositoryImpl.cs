using System;
using System.Collections.Generic;
using System.Linq;
using ApiRestfullpic.Model;
using ApiRestfullpic.Model.Context;
using Microsoft.EntityFrameworkCore;

namespace ApiRestfullpic.Repository.Implemantations
{
    public class UserRepositoryImpl : IUserRepository
    {
        private MySQLContext _context;
        private DbSet<T> dataset;

        public UserRepositoryImpl(MySQLContext context)
        {
            _context = context;
            dataset = _context.Set<T>();

        }

        public T FindById(long id)
        {
            return _context.Users.SingleOrDefault(u => u.id.Equals(id));
        }

        public T FindByGuid(string guid)
        {
            return _context.Users.SingleOrDefault(u => u.guid.Equals(guid));
        }
        
        public List<T> FindByKeyWord(string keyword)
        {
            if (!string.IsNullOrWhiteSpace(keyword))
                return _context.Users.Where(n => n.nome.Contains(keyword) && n.userName.Contains(keyword)).ToList();
            else
                return null;
        }
        
        public List<T> FindByKeyWordPaged(string query)
        {
            return dataset.FromSql<T>(query).ToList();

        }

        public int GetCount(string query)
        {
            var result = "";
            using (var connection = _context.Database.GetDbConnection())
            {
                connection.Open();

                using (var command = connection.CreateCommand())
                {
                    command.CommandText = query;
                    result = command.ExecuteScalar().ToString();
                }
            }

            return Int32.Parse(result);
        }
    }
}

