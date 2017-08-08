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
        private MainViewModel viewModel;

        public MainWindow()
        {
            InitializeComponent();
            viewModel = DataContext as MainViewModel;
        }


        private void OnNextClicked(object sender, RoutedEventArgs e)
        {
            viewModel.PagedUsers.MoveToNextPage();
        }

        private void OnPreviousClicked(object sender, RoutedEventArgs e)
        {
            viewModel.PagedUsers.MoveToPreviousPage();
        }
    }
}