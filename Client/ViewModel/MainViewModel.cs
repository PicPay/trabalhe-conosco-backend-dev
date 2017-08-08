using System;
using System.Windows.Documents;
using Data;
using GalaSoft.MvvmLight;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using GalaSoft.MvvmLight.Command;

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
            
            SearchCommand = new RelayCommand(Search, () => { return !string.IsNullOrEmpty(SearchText); });
        }

        private void Search()
        {
            throw new NotImplementedException();
        }
    }
}