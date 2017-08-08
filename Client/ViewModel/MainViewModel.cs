using System;
using System.Windows.Documents;
using Data;
using GalaSoft.MvvmLight;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.IO;
using System.Linq;
using System.Net;
using System.Web.Helpers;
using GalaSoft.MvvmLight.Command;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;

namespace Client.ViewModel
{
    /// <summary>
    /// This class contains properties that the main View can data bind to.
    /// <para>
    /// Use the <strong>mvvminpc</strong> snippet to add bindable properties to this ViewModel.
    /// </para>
    /// <para>
    /// You can also use Blend to data bind with the tool's support.
    /// </para>
    /// <para>
    /// See http://www.galasoft.ch/mvvm
    /// </para>
    /// </summary>
    public class MainViewModel : ViewModelBase
    {
        public ObservableCollection<user> Users { get; private set; }

        private RelayCommand searchCommand;
        public RelayCommand SearchCommand
        {
            get
            {
                return searchCommand;
            }

            set
            {
                if (searchCommand == value)
                {
                    return;
                }

                searchCommand = value;
                RaisePropertyChanged(() => SearchCommand);
            }
        }

        private string searchText = null;
        public string SearchText
        {
            get
            {
                return searchText;
            }

            set
            {
                if (searchText == value)
                {
                    return;
                }

                searchText = value;
                RaisePropertyChanged(() => SearchText);
            }
        }


        public MainViewModel()
        {
            Users = new ObservableCollection<user>();
            SearchCommand = new RelayCommand(Search);
        }

        private void Search()
        {
            string url = "http://localhost:50054/api/users/bytext/" + SearchText;
            HttpWebRequest request = ((HttpWebRequest)WebRequest.Create(url));

            using (var response = request.GetResponse())
            {
                using (var reader = new StreamReader(response.GetResponseStream()))
                {
                    var result = reader.ReadToEnd();
                    var users = JArray.Parse(result).Select(value => Json.Decode<user>(value.ToString()));
                    Users.Clear();
                    
                    foreach (var user in users)
                        Users.Add(user);
                }
            }
        }
    }
}