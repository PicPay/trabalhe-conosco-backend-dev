angular.module('mainApp')
    .controller('appCtrl', function ($scope, userService, notificationFactory) {
        $scope.nextPage;
        $scope.currentPage = "";
        $scope.previousPages = new Array();
        $scope.currentPageNumber = 0;
        $scope.filterValue = "";

        // Get Top 15 Users
        $scope.getStartUsers = function () {
            (new userService()).$getStart()
                .then(function (data) {
                    $scope.users = data.value;
                    $scope.nextPage = data["odata.nextLink"];
                    notificationFactory.success('Users loaded.');
                });
        };

        $scope.filterData = function () {
            if ($scope.filterValue != "")
            {
                $scope.currentPage = '$orderby=Priority&$filter=startswith(' + $scope.SelectedCriteria + ',' + '\'' + $scope.filterValue + '\'' + ')eq true';
                (new userService()).$filterData({ filter: $scope.currentPage })
                    .then(function (data) {
                        $scope.users = data.value;
                        $scope.previousPages = new Array();
                        $scope.nextPage = data["@odata.nextLink"];
                        $scope.currentPageNumber = 1;
                        $scope.currentPage =$scope.currentPage;
                        notificationFactory.success('Users loaded.');
                    });
            }
            else {
               
                $scope.currentPage = '$orderby=Priority';
                (new userService()).$filterData({ filter: $scope.currentPage })
                    .then(function (data) {
                        $scope.users = data.value;
                        $scope.previousPages = new Array();
                        $scope.nextPage = data["@odata.nextLink"];
                        $scope.currentPage = $scope.currentPage;
                        $scope.currentPageNumber = 1;
                        notificationFactory.success('Users loaded.');
                    });
            }
        };

        $scope.NextLink = function () {
            var nextPageLink = decodeURIComponent($scope.nextPage);
            nextPageLink = nextPageLink.match(/\?(.+)/)[1];

            (new userService()).$nextLink({ nextPage: nextPageLink })
                .then(function (data) {
                    $scope.previousPages.push($scope.currentPage);
                    $scope.currentPage = $scope.nextPage;
                    $scope.nextPage = data["@odata.nextLink"];
                    $scope.currentPageNumber = $scope.currentPageNumber + 1;
                    $scope.users = data.value;                    
                });
        };

        $scope.PreviousLink = function () {
            var previousPageLink = decodeURIComponent($scope.previousPages.pop());
            var previousPageLinkParameter = previousPageLink;

            try {var previousPageLinkParameter = previousPageLink.match(/\?(.+)/)[1];} catch (err){ }

            (new userService()).$previousLink({ previousPage: previousPageLinkParameter })
                .then(function (data) {
                    $scope.nextPage = $scope.currentPage;
                    $scope.currentPage = previousPageLink;
                    $scope.currentPageNumber = $scope.currentPageNumber - 1;
                    $scope.users = data.value;             
                });
        };

        $scope.hidePrevious = function () {
            return ($scope.previousPages.length == 0);
        }

        $scope.hideNext = function () {
            return $scope.nextPage == null;
        }

        $scope.Selectors = ["Name", "Username"];
        $scope.SelectedCriteria = $scope.Selectors[0];
    });