#region

using System.Windows;
using Client.Helper;

#endregion

namespace Client.View
{
    /// <summary>
    ///     Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private readonly PagingCollectionView _cview;

        public MainWindow()
        {
            InitializeComponent();
        }

        private void OnNextClicked(object sender, RoutedEventArgs e)
        {
            _cview.MoveToNextPage();
        }

        private void OnPreviousClicked(object sender, RoutedEventArgs e)
        {
            _cview.MoveToPreviousPage();
        }
    }
}