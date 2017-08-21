using Domain.Entities;
using Domain.Interfaces.Repositories;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Text;

namespace Repository.Repositories
{
    public class Cache : ICache<User>
    {
        private List<User> _elements;
        private List<string> _rel01;
        private List<string> _rel02;

        public void Set()
        {
            #region[CSV]
            this._elements = new List<User>();
            string resourceName = Configuration.Constant.RESOURCE_NAME_USER;
            Assembly assembly = Assembly.GetEntryAssembly();
            string line = "";

            using (Stream stream = assembly.GetManifestResourceStream(resourceName))
            {
                using (StreamReader reader = new StreamReader(stream, Encoding.UTF8))
                {
                    while ((line = reader.ReadLine()) != null)
                    {
                        string[] lines = line.Split(',');
                        if (lines != null && lines.Length == 3)
                        {
                            this._elements.Add(new User { ID = new Guid(lines[0]), Name = lines[1], UserName = lines[2] });
                        }
                    }
                }
            }
            #endregion

            #region[TXT]
            string[] resources = new string[2];
            resources[0] = Configuration.Constant.RESOURCE_NAME_REL1;
            resources[1] = Configuration.Constant.RESOURCE_NAME_REL2;
            _rel01 = new List<string>();
            _rel02 = new List<string>();

            foreach (var resource in resources)
            {
                using (Stream stream = assembly.GetManifestResourceStream(resource))
                {
                    using (StreamReader reader = new StreamReader(stream, Encoding.UTF8))
                    {
                        while ((line = reader.ReadLine()) != null)
                        {
                            if (resource.Equals(Configuration.Constant.RESOURCE_NAME_REL1))
                            {
                                this._rel01.Add(line.Trim().ToUpper());
                            }
                            else
                            {
                                this._rel02.Add(line.Trim().ToUpper());
                            }
                        }
                    }
                }
            }
            #endregion
        }

        public void Set(User user)
        {
            if (this._elements == null || user == null)
            {
                return;
            }

            if (!this._elements.Exists(x => x.ID.ToString().ToUpper().Equals(user.ID.ToString().ToUpper())))
            {
                this._elements.Add(user);
            }
        }

        public bool Remove(User user)
        {
            return this._elements == null ? false : this._elements.Remove(user);
        }

        public User Get(User user)
        {
            if (this._elements == null)
            {
                return new User();
            }

            return this._elements.Find(x => x.ToString().ToUpper().Equals(user.ID.ToString().ToUpper()));
        }

        public IQueryable<User> GetAll()
        {
            return this._elements.AsQueryable<User>();
        }

        public void Clear()
        {
            if (this._elements == null)
            {
                return;
            }

            this._elements.Clear();
        }

        public List<string> GetAllRel01()
        {
            return this._rel01;
        }

        public List<string> GetAllRel02()
        {
            return this._rel02;
        }
    }
}
