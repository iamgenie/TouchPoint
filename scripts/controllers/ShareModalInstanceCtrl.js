
app.controller('ShareModalInstanceCtrl', function ($scope, $http, $filter, $uibModalInstance, items,$timeout) {      
	

	$scope.linkToShare = items[0];              
	$scope.copyLinkButtonText = "Copy Link";
	
	
	$scope.onSuccess = function(e) {
		

	    $scope.copyLinkButtonText = "Copied!";
		
		$timeout(function () {
			
			$scope.cancel(); 
			
		}, 1000);  

	    e.clearSelection();

	};

	$scope.onError = function(e) {  
		
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
	}


	
	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel'); 
	};
  
});