requirejs(["sidebae"], function(sidebae) {
    //This function is called when scripts/helper/util.js is loaded.
    //If util.js calls define(), then this function is not fired until
    //util's dependencies have loaded, and the util argument will hold
    //the module value for "helper/util".
});
/*
require.config({
	baseUrl: '../js',
	// ... config ...
	paths: {
		angular: '../bower_components/angular/angular'
	}
	// ... config ...
});
requirejs(['angular'],function (angular) {console.log(angular);});
*/