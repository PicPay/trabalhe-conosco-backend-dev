using Application;
using Application.Interfaces;
using Domain.Entities;
using Domain.Interfaces.Repositories;
using Microsoft.Extensions.DependencyInjection;
using Repository.Repositories;

namespace IoC
{
    public class InjectionDependency
    {
        public static IServiceCollection Register(IServiceCollection services)
        {
            //Application
            services.AddScoped<IUserApService, UserApService>();
            services.AddScoped<ILoginApService, LoginApservice>();

            // Infra - Data
            services.AddScoped<IRepository<User>, Repository<User>>();
            services.AddScoped<ILoginRepository, LoginRepository>();
            services.AddSingleton<ICache<User>, Cache>();

            return services;
        }
    }
}
