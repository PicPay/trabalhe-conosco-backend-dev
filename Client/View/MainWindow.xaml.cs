#region

using System;
using System.Collections.Generic;
using System.Windows;
using Client.Helper;
using Client.ViewModel;

#endregion

namespace Client.View
{
    /// <summary>
    ///     Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private readonly PagingCollectionView _collectionView;

        public MainWindow()
        {
            InitializeComponent();
            var viewmodel = DataContext as MainViewModel;
            if (viewmodel != null)
                _collectionView = new PagingCollectionView(viewmodel.Users, 15);
        }

        private void OnNextClicked(object sender, RoutedEventArgs e)
        {
            _collectionView.MoveToNextPage();
        }

        private void OnPreviousClicked(object sender, RoutedEventArgs e)
        {
            _collectionView.MoveToPreviousPage();
        }
    }
}