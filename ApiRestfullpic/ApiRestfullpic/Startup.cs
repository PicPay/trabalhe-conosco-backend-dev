using ApiRestfullpic.Model.Context;
using ApiRestfullpic.Business;
using ApiRestfullpic.Repository.Implemantations;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Rewrite;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Swashbuckle.AspNetCore.Swagger;
using ApiRestfullpic.Repository;
using ApiRestfullpic.Business.Implemantations;

namespace ApiRestfullpic
{
    public class Startup
    {


        public IConfiguration Configuration { get; }

        public Startup(IConfiguration configuration)
        {
            Configuration = configuration;

        }

    

        // This method gets called by the runtime. Use this method to add services to the container.
        public void ConfigureServices(IServiceCollection services)
        {
            //conexão com banco
            var connection = Configuration["MySqlConnection:MySqlConnectionString"];
            services.AddDbContext<MySQLContext>(options => options.UseMySql(connection));

            //incluindo swagger
            services.AddSwaggerGen(s => 
            {
                s.SwaggerDoc("v1", new Info { Title = "RestApi PicPay (Teste back-end)" });


            });
            //versionamento de api
            services.AddApiVersioning();


            services.AddMvc().SetCompatibilityVersion(CompatibilityVersion.Version_2_1);

            //injeção de dependencia 
            services.AddScoped<IUserBusiness, UserBusinessImpl>();
            services.AddScoped<IUserRepository, UserRepositoryImpl>();
        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IHostingEnvironment env)
        {
            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
            }
            
            app.UseMvc();

            //configurações do swagger
            app.UseSwagger();
            app.UseSwaggerUI(s => 
            {
                s.SwaggerEndpoint("/swagger/v1/swagger.json", "Api PicPay V1");

            });

            var option = new RewriteOptions();

            option.AddRedirect("^$","swagger");
            app.UseRewriter(option);

        }
    }
}
