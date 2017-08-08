#region

using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Description;
using Data;

#endregion

namespace WebService.Controllers
{
    public class UsersController : ApiController
    {
        private readonly PicPayEntities db = new PicPayEntities();

        // GET: api/users
        public IQueryable<user> Getusers()
        {
            return db.users;
        }

        // GET: api/users/5
        [ResponseType(typeof(user))]
        public async Task<IHttpActionResult> Getuser(string id)
        {
            var user = await db.users.FindAsync(id);
            if (user == null)
                return NotFound();

            return Ok(user);
        }

        // GET: api/users/John
        [ResponseType(typeof(user))]
        public IQueryable<user> GetuserByNameOrUsername(string text)
        {
            var users = db.users.Where(user => user.Nome.Contains(text) || user.Username.Contains(text));
            return users;
        }

        // PUT: api/users/5
        [ResponseType(typeof(void))]
        public async Task<IHttpActionResult> Putuser(string id, user user)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            if (id != user.ID)
                return BadRequest();

            db.Entry(user).State = EntityState.Modified;

            try
            {
                await db.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!userExists(id))
                    return NotFound();

                throw;
            }

            return StatusCode(HttpStatusCode.NoContent);
        }

        // POST: api/users
        [ResponseType(typeof(user))]
        public async Task<IHttpActionResult> Postuser(user user)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            db.users.Add(user);

            try
            {
                await db.SaveChangesAsync();
            }
            catch (DbUpdateException)
            {
                if (userExists(user.ID))
                    return Conflict();

                throw;
            }

            return CreatedAtRoute("DefaultApi", new {id = user.ID}, user);
        }

        // DELETE: api/users/5
        [ResponseType(typeof(user))]
        public async Task<IHttpActionResult> Deleteuser(string id)
        {
            var user = await db.users.FindAsync(id);
            if (user == null)
                return NotFound();

            db.users.Remove(user);
            await db.SaveChangesAsync();

            return Ok(user);
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
                db.Dispose();
            base.Dispose(disposing);
        }

        private bool userExists(string id)
        {
            return db.users.Count(e => e.ID == id) > 0;
        }
    }
}