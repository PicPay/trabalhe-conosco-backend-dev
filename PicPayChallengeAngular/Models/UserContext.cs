using PicPayChallenge.Models;
using System.Data.Entity;
namespace ProductService.Models
{
    public class UsersContext : DbContext
    {
        public UsersContext()
                : base("DefaultConnection")
        {
        }
        public DbSet<User> Users { get; set; }
    }
}