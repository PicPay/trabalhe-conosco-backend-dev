#region

using System.Collections;
using System.ComponentModel;
using System.Windows.Data;

#endregion

namespace Client
{
    public class PagingCollectionView : CollectionView
    {
        private readonly IList _innerList;

        private int _currentPage = 1;

        public PagingCollectionView(IList innerList, int itemsPerPage)
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
                if (_currentPage < PageCount) // page 1..n-1
                    return ItemsPerPage;

                var itemsLeft = _innerList.Count % ItemsPerPage;
                if (0 == itemsLeft)
                    return ItemsPerPage; // exactly itemsPerPage left

                return itemsLeft;
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