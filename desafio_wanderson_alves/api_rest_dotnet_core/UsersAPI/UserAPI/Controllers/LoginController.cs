using Application.Interfaces;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json.Linq;

namespace UserAPI.Controllers
{
    [Route("api/[controller]")]
    public class LoginController : Controller
    {
        private readonly ILoginApService _loginApService;

        public LoginController(ILoginApService loginApService)
        {
            this._loginApService = loginApService;
        }

        [HttpPost]
        public IActionResult Post([FromBody] JObject data)
        {
            try
            {
                string userName = data["UserName"].ToString();
                var token = this._loginApService.Login(userName);
                return string.IsNullOrWhiteSpace(token) ? StatusCode(400, new { Token = "", Status = false }) : Ok(new { Token = token, Status = true });
            }
            catch
            {
                return StatusCode(400, new { Token = "", Status = false });
            }
        }
    }
}
