using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Threading.Tasks;

namespace ApiRestfullpic.Model
{
    [DataContract]
    public class T
    {
        [DataMember (Order = 1)]
        public long id { get; set; }

        [DataMember(Order = 2)]
        public string guid { get; set; }

        [DataMember(Order = 4)]
        public string nome { get; set; }

        [DataMember(Order = 3)]
        public string userName { get; set; }
     }
}
