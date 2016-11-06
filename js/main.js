requirejs(["sidebae"], function(sidebae) {
    //This function is called when scripts/helper/util.js is loaded.
    //If util.js calls define(), then this function is not fired until
    //util's dependencies have loaded, and the util argument will hold
    //the module value for "helper/util".
});

require.config({
	baseUrl: '../js',
	// ... config ...
	paths: {
		colorbox: '../bower_components/jquery-colorbox/jquery.colorbox-min',
		sweetalert: '../bower_components/sweetalert/dist/sweetalert.min'
	}
	// ... config ...
});
requirejs(['colorbox'],function (colorbox) {});
requirejs(['sweetalert'],function (sweetalert) {});