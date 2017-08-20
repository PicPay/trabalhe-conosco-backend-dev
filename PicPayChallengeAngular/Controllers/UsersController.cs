using PicPayChallenge.Models;
using ProductService.Models;
using System;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Linq;
using System.Web.Http;
using System.Web.Mvc;
using System.Web.OData;

namespace ProductService.Controllers
{
    public class UsersController : ODataController
    {
        UsersContext db = new UsersContext();

        [EnableQuery(PageSize = 15)]
        public IQueryable<User> Get()
        {
            return db.Users;
        }

        [EnableQuery]
        public SingleResult<User> Get([FromODataUri] Guid key)
        {
            IQueryable<User> result = db.Users.Where(p => p.Id == key);
            return SingleResult.Create(result);
        }

        private bool ProductExists(Guid key)
        {
            return db.Users.Any(p => p.Id == key);
        }
        protected override void Dispose(bool disposing)
        {
            db.Dispose();
            base.Dispose(disposing);
        }
    }
}