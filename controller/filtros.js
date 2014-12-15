/**
 * Created by artiom on 28/11/14.
 */

myapp.filter('startFrom', function() {
	return function(input, start) {
		start = +start; //parse to int
		return input.slice(start);
	}
});
