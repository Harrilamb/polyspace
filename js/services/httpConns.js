app.factory('currTeam', ['$http', function($http) { 
  return $http.get("../php/sqlHandlers.php?action=current_team") 
            .success(function(data) { 
              return data; 
            }) 
            .error(function(err) { 
              return err; 
            }); 
}]);
app.factory('otherTeams', ['$http', function($http) { 
  return $http.get("../php/sqlHandlers.php?action=other_teams") 
            .success(function(data) { 
              return data; 
            }) 
            .error(function(err) { 
              return err; 
            }); 
}]);
app.factory('currProj', ['$http',function($http){
  return $http.get("../php/sqlHandlers.php?action=current_project") 
            .success(function(data) { 
              return data; 
            }) 
            .error(function(err) { 
              return err; 
            }); 
}]);
app.factory('otherProjs',['$http',function($http){
	return	$http.get("../php/sqlHandlers.php?action=other_projects")
			.success(function(data) {
				return data;
			})
			.error(function(err) {
				return err;
			});
}]);
app.factory('allSystems',['$http',function($http){
	return	$http.get("../php/sqlHandlers.php?action=all_systems")
			.success(function(data) {
				console.log(data);
				return data;
			})
			.error(function(err) {
				return err;
			});
}]);
app.factory('allRequirements',['$http',function($http){
	return	$http.get("../php/sqlHandlers.php?action=all_requirements")
			.success(function(data) {
				return data;
			})
			.error(function(err) {
				return err;
			});
}]);
app.factory('allVariables',['$http',function($http){
	return	$http.get("../php/sqlHandlers.php?action=all_variables")
			.success(function(data) {
				return data;
			})
			.error(function(err) {
				return err;
			});
}]);