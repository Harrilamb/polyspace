require.config({
	baseUrl: '../js',
	// ... config ...
	paths: {
		jquery: '../bower_components/jquery/dist/jquery.min',
		bootstrap: '../bower_components/bootstrap/dist/js/bootstrap.min',
		colorbox: '../bower_components/jquery-colorbox/jquery.colorbox-min',
		sweetalert: '../bower_components/sweetalert/dist/sweetalert.min'
	}
	// ... config ...
});

requirejs(['jquery'],function (jquery) {
	requirejs(['bootstrap'],function (bootstrap) {});
	requirejs(['colorbox'],function (colorbox) {});
	requirejs(['sweetalert'],function (sweetalert) {});

	requirejs(["sidebae"], function(sidebae) {
		//This function is called when scripts/helper/util.js is loaded.
		//If util.js calls define(), then this function is not fired until
		//util's dependencies have loaded, and the util argument will hold
		//the module value for "helper/util".
	});
});