var app = angular.module('app', []);

app.controller('RegionCRUDCtrl', ['$scope', 'RegionCRUDService', 
    function ($scope, RegionCRUDService) {

        $scope.getRegion = function () {
            var id = $scope.region.id;
            RegionCRUDService.getRegion($scope.region.id)
                .then(function success(response) {
                    $scope.region = response.data.data;
                    $scope.region.id = id;
                    $scope.region.country_id = response.data.data.country_id;
                    $scope.message='';
                    $scope.errorMessage = '';
                },
                function error (response) {
                    $scope.message = '';
                    if (response.status === 404){
                        $scope.errorMessage = 'Region not found!';
                    }
                    else {
                        $scope.errorMessage = "Error getting region!";
                    }
                });
        };

        $scope.addSubscription = function () {
            if ($scope.subscription != null && $scope.subscription.name) {


                SubscriptionCRUDService.addSubscription($scope.subscription.name)
                    .then (function success(response){
                            $scope.message = 'Subscription added!';
                            $scope.errorMessage = '';
                        },
                        function error(response){
                            $scope.errorMessage = 'Error adding subscription!';
                            $scope.message = '';
                        });
            }
            else {
                $scope.errorMessage = 'Please enter a name!';
                $scope.message = '';
            }
        };

        $scope.updateSubscription = function () {
            SubscriptionCRUDService.updateSubscription($scope.subscription.id,$scope.subscription.name)
                .then(function success(response){
                        $scope.message = 'Subscription data updated!';
                        $scope.errorMessage = '';
                    },
                    function error(response){
                        $scope.errorMessage = 'Error updating subscription!';
                        $scope.message = '';
                    });
        };

        $scope.deleteSubscription = function () {
            SubscriptionCRUDService.deleteSubscription($scope.subscription.id)
                .then (function success(response){
                        $scope.message = 'Subscription deleted!';
                        $scope.subscription = null;
                        $scope.errorMessage='';
                    },
                    function error(response){
                        $scope.errorMessage = 'Error deleting subscription!';
                        $scope.message='';
                    });
        };

        $scope.getAllRegions = function () {
            RegionCRUDService.getAllRegions()
                .then(function success(response){
                        $scope.regions = response.data.data;
                        $scope.message=''
                        $scope.errorMessage = '';
                    },
                    function error (response ){
                        $scope.message='';
                        $scope.errorMessage = 'Error getting subscriptions!';
                    });
        };

}]);

app.service('RegionCRUDService',['$http', function ($http) {
    
    this.getRegion = function getRegion(regionId){
        return $http({
          method: 'GET',
          url: 'api/regions/'+ regionId,
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json'}
        });
    }
    
    this.addRegion = function addRegion(name, country_id){
        return $http({
          method: 'POST',
          url: 'api/regions',
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json'},
          data: {
              name:name, 
              country_id:country_id
            }
        });
    }
    
    this.updateRegion = function updateRegion(id, name, country_id){
        return $http({
          method: 'PATCH',
          url: 'api/regions/'+ id,
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json'},
          data: {
              name:name, 
              country_id:country_id
            }
        })
    }

    this.deleteRegion = function deleteRegion(id){
        return $http({
          method: 'DELETE',
          url: 'api/regions/'+ id,
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json'}
        })
    }
    
    this.getAllRegions  = function getAllRegions(){
        return $http({
          method: 'GET',
          url: 'api/regions',
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json'}
        });
    }

}]);

// either this or print them before hand with php
window.onload = function () { $("#get_all_regs").click(); }