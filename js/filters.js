var myApp = angular.module('app',[])
.filter('html',function($sce){
    return function(input){
        return $sce.trustAsHtml(input);
    }
})

function myCtrl($scope,$sce){
    $scope.html = 'âˆ†';
}