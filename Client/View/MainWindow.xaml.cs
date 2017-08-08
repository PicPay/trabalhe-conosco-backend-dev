#region

using System;
using System.Collections.Generic;
using System.Windows;
using Client.Helper;
using Client.ViewModel;
using Data;

#endregion

namespace Client.View
{
    /// <summary>
    ///     Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
            var viewmodel = DataContext as MainViewModel;

            if (viewmodel != null)
                CollectionView = new PagingCollectionView<user>(viewmodel.Users, 15);
        }

        public PagingCollectionView<user> CollectionView { get; }


        private void OnNextClicked(object sender, RoutedEventArgs e)
        {
            CollectionView.MoveToNextPage();
            var viewmodel = DataContext as MainViewModel;
        }

        private void OnPreviousClicked(object sender, RoutedEventArgs e)
        {
            CollectionView.MoveToPreviousPage();
            var viewmodel = DataContext as MainViewModel;
        }
    }
}