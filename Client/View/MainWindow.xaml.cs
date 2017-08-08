#region

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
        private readonly PagingCollectionView collectionView;
        private MainViewModel viewmodel;

        public MainWindow()
        {
            InitializeComponent();
            viewmodel = DataContext as MainViewModel;
        }
        
        private void OnNextClicked(object sender, RoutedEventArgs e)
        {
            collectionView.MoveToNextPage();
        }

        private void OnPreviousClicked(object sender, RoutedEventArgs e)
        {
            collectionView.MoveToPreviousPage();
        }
    }
}