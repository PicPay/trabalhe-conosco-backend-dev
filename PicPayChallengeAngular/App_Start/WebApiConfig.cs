using System;
using System.Collections.Generic;
using System.Linq;
using System.Web.Http;
using ProductService.Models;
using System.Web.OData.Builder;
using System.Web.OData.Extensions;
using PicPayChallenge.Models;
using Microsoft.OData.Edm;
using System.Web.OData.Batch;

namespace PicPayChallengeAngular
{
    public static class WebApiConfig
    {
        public static void Register(HttpConfiguration config)
        {
            config.MapODataServiceRoute("odata", "api", GetEdmModel(), new DefaultODataBatchHandler(GlobalConfiguration.DefaultServer));
            config.Count().Filter().OrderBy().Expand().Select().MaxTop(null);
            config.EnsureInitialized();
        }

        private static IEdmModel GetEdmModel()
        {
            ODataConventionModelBuilder builder = new ODataConventionModelBuilder();
            
            builder.Namespace = "Demos";
            builder.ContainerName = "DefaultContainer";
            builder.EntitySet<User>("Users");
            var edmModel = builder.GetEdmModel();
            return edmModel;
        }
    }
}
