angular.module('userInfoApp.controllers',[]).
controller('setTeams',['$scope','currTeam', function($scope, currTeam){
	currTeam.success(function(data){
		$scope.thisTeam = data.records;
	});
}]);