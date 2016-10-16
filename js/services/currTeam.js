app.factory('currTeam', ['$http', function($http) { 
  return $http.get("../php/sqlHandlers.php?action=find_current_team") 
            .success(function(data) { 
              return data; 
            }) 
            .error(function(err) { 
              return err; 
            }); 
}]);