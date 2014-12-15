/**
 * Created by artiom on 03/12/14.
 */
myapp.directive('toupper', function() {
	return {
		require: 'ngModel',
		link: function(scope, element, attrs, modelCtrl) {
			var mayusculas = function(inputValue) {
				if (inputValue != undefined && inputValue != ''){
					var capitalized = inputValue.toUpperCase();
					if(capitalized !== inputValue) {
						modelCtrl.$setViewValue(capitalized);
						modelCtrl.$render();
					}
					return capitalized;
				}
			};
			modelCtrl.$parsers.push(mayusculas);
			mayusculas(scope[attrs.ngModel]);  // capitalize initial value
		}
	};
});