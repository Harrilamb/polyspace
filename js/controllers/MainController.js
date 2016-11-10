angular.module('userInfoApp.controllers',[]).
controller('setTeams',['$scope','currTeam','otherTeams','currProj','otherProjs'/*,'allSystems'*/,'allRequirements', 'allVariables', function($scope, currTeam, otherTeams, currProj, otherProjs/*, allSystems*/, allRequirements, allVariables){
	currTeam.success(function(data){
		$scope.thisTeam = data.records;
	});
	otherTeams.success(function(data){
		$scope.otherTeams = data.records;
	});
	currProj.success(function(data){
		$scope.currProj = data.records;
	});
	otherProjs.success(function(data){
		$scope.otherProjs = data.records;
	});
	/*allSystems.success(function(data){
		$scope.allSystems = data.records;
	});*/
	allRequirements.success(function(data){
		$scope.allRequirements = data.records;
	});
	allVariables.success(function(data){
		$scope.allVariables = data.records;
	});
}]);