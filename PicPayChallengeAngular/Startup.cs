using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(PicPayChallengeAngular.Startup))]
namespace PicPayChallengeAngular
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            ConfigureAuth(app);
        }
    }
}
