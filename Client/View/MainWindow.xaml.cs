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

            //if (viewmodel != null)
            //    CollectionView = new PagingCollectionView(viewmodel.Users, 15);

            CollectionView = new PagingCollectionView(
                                                      new List<user>
                                                      {
                                                          new user
                                                          {
                                                              ID = "065d8403-8a8f-484d-b602-9138ff7dedcf",
                                                              Nome = "Wadson marcia",
                                                              Username = "wadson.marcia"
                                                          },
                                                          new user
                                                          {
                                                              ID = "5761be9e-3e27-4be8-87bc-5455db08408",
                                                              Nome = "Kylton Saura",
                                                              Username = "kylton.saura"
                                                          },
                                                          new user
                                                          {
                                                              ID = "aaa40f4e-da26-42ee-b707-cb81e00610d5",
                                                              Nome = "Raimundira M",
                                                              Username = "raimundiram"
                                                          },
                                                          new user
                                                          {
                                                              ID = "51ba0961-8d5b-47be-bcb4-54633a567a99",
                                                              Nome = "Pricila Kilder",
                                                              Username = "pricilakilderitaliani"
                                                          }
                                                      },
                                                      15);
        }

        public PagingCollectionView CollectionView { get; }


        private void OnNextClicked(object sender, RoutedEventArgs e)
        {
            CollectionView.MoveToNextPage();
        }

        private void OnPreviousClicked(object sender, RoutedEventArgs e)
        {
            CollectionView.MoveToPreviousPage();
        }
    }
}