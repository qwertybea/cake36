var app = angular.module('linkedlists', []);

app.controller('countriesController', function ($scope, $http) {
    // l'url vient de add.ctp
    $http.get(urlToLinkedListFilter).then(function (response) {
        $scope.countries = response.data;
    });
});

