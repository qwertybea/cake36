var onloadCallback = function() {
    widgetId1 = grecaptcha.render('capcha', {
        'sitekey': '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
        'theme': 'light'
    });
};

var app = angular.module('app', []);

app.controller('UsersController', function($scope, $http) {

    // Login Process
    $scope.login = function () {

        if (grecaptcha.getResponse(widgetId1) == '') {
            $scope.captcha_status = 'Please verify captha.';
            return;
        }

        var req = {
            method: 'POST',
            url: 'api/users/token',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            data: {username: $scope.username, password: $scope.password}
        }
        // fields in key-value pairs
        $http(req)
                .then(function (jsonData, status, headers, config) {
                    // console.log(jsonData.data.token);
                    // tell the user was logged
                    localStorage.setItem('token', jsonData.data.data.token);
                    localStorage.setItem('user_id', jsonData.data.data.user_id);
                    $('#logout').show();
                    $('#motpasse').show();
                    $('#modififcationAjout').show();
                    $('#login').hide();
                    alert('User sucessfully logged in');
                },function(data, status, headers, config) {
                    //console.log(data.response.result);
                    // tell the user was not logged
                    alert('Erreur lors de la connexion');
                });
    }
    // Login Process
    $scope.logout = function () {
        localStorage.setItem('token', "no token");
        localStorage.setItem('user_id', null);
        $('#logout').hide();
        $('#motpasse').hide();
        $('#modififcationAjout').hide();
        $('#login').show();
        alert("User sucessfully logged out");
    }
    $scope.changePassword = function () {
        var req = {
            method: 'PUT',
            url: 'api/users/' + localStorage.getItem("user_id"),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem("token")
            },
            data: {'password': $scope.newPassword}
        }
        $http(req)
                .then(function (response) {
                    // tell the user subcategory record was updated
                    alert('Password successfully changed');
                },function(response) {
                    // tell the user subcategory record was not updated
                    //console.log(response);
                    alert('Could not update Password');
                });
    }
});

app.controller('RegionCRUDCtrl', ['$scope', 'RegionCRUDService', 
    function ($scope, RegionCRUDService) {

        $scope.getRegion = function () {
            var id = $scope.region.id;
            RegionCRUDService.getRegion($scope.region.id)
                .then(function success(response) {
                    $scope.region = response.data.data;
                    $scope.region.id = id;
                    $scope.region.country_id = response.data.data.country_id;

                    //temp
                    $('#country-id > option[selected]').each(function () {
                        console.log(this)
                        $(this).prop('selected', false);
                    })
                    $('#country-id > option').eq(response.data.data.country_id).attr('selected','selected');

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

        $scope.addRegion = function () {
            if ($scope.region != null && $scope.region.name) {
                RegionCRUDService.addRegion($scope.region.name, $scope.region.country_id)
                    .then (function success(response){
                            $scope.message = 'Region added!';
                            $scope.region.id = response.data.data.id;
                            $scope.errorMessage = '';
                            $scope.getAllRegions();
                        },
                        function error(response){
                            $scope.errorMessage = 'Error adding region!';
                            $scope.message = '';
                        });
            }
            else {
                $scope.errorMessage = 'Please enter a name!';
                $scope.message = '';
            }
        };

        $scope.updateRegion = function () {
            RegionCRUDService.updateRegion($scope.region.id, $scope.region.name, $scope.region.country_id)
                .then(function success(response){
                        $scope.message = 'Region data updated!';
                        $scope.errorMessage = '';
                        $scope.getAllRegions();
                    },
                    function error(response){
                        $scope.errorMessage = 'Error updating region!';
                        $scope.message = '';
                    });
        };

        $scope.deleteRegion = function () {
            RegionCRUDService.deleteRegion($scope.region.id)
                .then (function success(response){
                        $scope.message = 'Region deleted!';
                        $scope.region = null;
                        $scope.errorMessage='';
                        $scope.getAllRegions();
                    },
                    function error(response){
                        $scope.errorMessage = 'Error deleting region!';
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
                        $scope.errorMessage = 'Error getting regions!';
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
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json', 'X-CSRF-Token': csrfToken},
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
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json', 'X-CSRF-Token': csrfToken},
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
          headers: { 'X-Requested-With' : 'XMLHttpRequest', 'Accept' : 'application/json', 'X-CSRF-Token': csrfToken}
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