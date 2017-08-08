#region

using System.Collections;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Windows.Data;
using System.Linq;

#endregion

namespace Client.Helper
{
    public class PagingCollectionView<T> : ListCollectionView
    {
        private readonly ObservableCollection<T> _innerList;

        private int _currentPage = 1;

        public PagingCollectionView(ObservableCollection<T> innerList, int itemsPerPage)
            : base(innerList)
        {
            _innerList = innerList;
            ItemsPerPage = itemsPerPage;
        }

        public override int Count
        {
            get
            {
                if (_innerList.Count == 0)
                    return 0;

                //all pages except the last
                if (CurrentPage < PageCount)
                    return ItemsPerPage;

                //last page
                var remainder = _innerList.Count % ItemsPerPage;

                return remainder == 0 ? ItemsPerPage : remainder;
            }
        }

        public int CurrentPage
        {
            get => _currentPage;
            set
            {
                _currentPage = value;
                OnPropertyChanged(new PropertyChangedEventArgs("CurrentPage"));
            }
        }

        public int ItemsPerPage { get; }

        public int PageCount => (_innerList.Count + ItemsPerPage - 1)
                                / ItemsPerPage;

        private int EndIndex
        {
            get
            {
                var end = _currentPage * ItemsPerPage - 1;
                return end > _innerList.Count ? _innerList.Count : end;
            }
        }

        private int StartIndex => (_currentPage - 1) * ItemsPerPage;

        public override object GetItemAt(int index)
        {
            var offset = index % ItemsPerPage;
            return _innerList[StartIndex + offset];
        }

        public void MoveToNextPage()
        {
            if (_currentPage < PageCount)
                CurrentPage += 1;
            Refresh();
        }

        public void MoveToPreviousPage()
        {
            if (_currentPage > 1)
                CurrentPage -= 1;
            Refresh();
        }
    }
}