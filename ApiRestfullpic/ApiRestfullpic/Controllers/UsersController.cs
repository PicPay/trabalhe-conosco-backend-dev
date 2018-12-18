using ApiRestfullpic.Business;
using ApiRestfullpic.Model;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;

namespace ApiRestfullpic.Controllers
{
    [ApiVersion("1")] 
    [Route("api/[controller]/v{version:apiVersion}")]
    [ApiController]
    public class UsersController : ControllerBase
    {

        private IUserBusiness _userBusiness; 

        public UsersController(IUserBusiness userBusiness)
        {
            _userBusiness = userBusiness;
        }
        #region HTTP GET

        /// // GET api/users/version/{id}
        [ProducesResponseType((200), Type = typeof(List<T>))]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        [ProducesResponseType(401)]
        [HttpGet, Route("id/{id}")]
        public ActionResult FindById(long id)
        {
            var user = _userBusiness.FindById(id);
            if (user == null) return NotFound();
            return Ok(user);
        }

        /// GET api/users/version/{guid}
        [ProducesResponseType((200), Type = typeof(List<T>))]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        [ProducesResponseType(401)]
        [HttpGet, Route("guid/{guid}")]
        public ActionResult FindByGuid(string guid)
        {
            var user = _userBusiness.FindByGuid(guid);
            if (user == null) return NotFound(); 
            return Ok(user);
        }

        /// GET api/users/desc/{pageSize}/{page}?={keyword}
        /// 
        ///<remarks>
        ///Exemplo de requisição:
        ///https://localhost:44358/api/Users/v1/find-by-paged-search/desc/15/1?keyword=rafael
        ///</remarks>
        [ProducesResponseType((200), Type = typeof(List<T>))]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        [ProducesResponseType(401)]
        [ProducesResponseType(404)]
        [HttpGet, Route("find-by-paged-search/{sortDirection}/{pageSize}/{page}")]
        public IActionResult GetPagedSearch([FromQuery] string keyword, string sortDirection, int pageSize, int page)
        {
                      
            return new OkObjectResult(_userBusiness.FindByKeyWordPaged(keyword, sortDirection, pageSize, page));
        }
           

        #endregion

    }
}
