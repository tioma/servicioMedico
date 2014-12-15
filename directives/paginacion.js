/**
 * Created by artiom on 13/11/14.
 */
myapp.directive('divPagination', function(){
	return {
		restrict:		'E',
		templateUrl:	'view/div.pagination.html',
		scope: {
			totalItems:			'=',
			currentPage:		'='
		},
		link: function($scope){
			$scope.$watch('totalItems', function(){
				if ($scope.totalItems >= 10000){
					$scope.maxSizeSM = 9;
					$scope.maxSizeMD = 13;
					$scope.maxSizeLG = 17;
				} else {
					$scope.maxSizeSM = 10;
					$scope.maxSizeMD = 15;
					$scope.maxSizeLG = 20;
				}
			});
			$scope.pageChanged = function(){
				$scope.$emit('cambioPagina', $scope.currentPage);
			}
		}
	}
});