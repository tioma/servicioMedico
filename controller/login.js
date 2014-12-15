/**
 * Created by Diego Reyes on 1/23/14.
 */
function loginCtrl($scope, $state, authFactory){
	'use strict';
	$scope.sesion = false;

	$scope.login = function(){
		authFactory.login($scope.email, $scope.password, function(data){
			if ($scope.sesion){
				authFactory.setCookies(data.email, data.password);
			}
			$state.transitionTo('proximasAltas');
		});
	};

}
