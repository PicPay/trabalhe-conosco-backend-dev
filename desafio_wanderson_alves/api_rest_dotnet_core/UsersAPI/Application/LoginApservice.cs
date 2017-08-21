using Application.Interfaces;
using Domain.Interfaces.Repositories;

namespace Application
{
    public class LoginApservice : ILoginApService
    {
        private readonly ILoginRepository _loginRepository;

        public LoginApservice(ILoginRepository loginRepository)
        {
            this._loginRepository = loginRepository;
        }

        public string Login(string userName)
        {
            if (string.IsNullOrWhiteSpace(userName))
            {
                return "";
            }

            return this._loginRepository.Login(userName);
        }
    }
}
