using Application.Interfaces;
using Microsoft.AspNetCore.Mvc;

namespace UserAPI.Controllers
{
    [Route("api/[controller]")]
    public class UserController : Controller
    {
        private readonly IUserApService _userApService;

        public UserController(IUserApService userApService)
        {
            this._userApService = userApService;
        }

        [HttpGet("{page:int}/{pageSize:int}/{search?}")]
        public IActionResult Get(int page, int pageSize, string search = "")
        {
            var result = this._userApService.Paginate(page, pageSize, string.IsNullOrWhiteSpace(search)?"": search.Replace("''",""));
            return Ok(result);
        }
    }
}
