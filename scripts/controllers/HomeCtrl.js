//'use strict';   not using strict since google maps needs to be optimized

app.controller('HomeCtrl', function($scope,$rootScope, $q, $http, $filter, $uibModal, $log, $location, authEngine) {    

	if(!authEngine.memberDetails().memberId){
		$location.path('/logIn'); 
	}
	
	$scope.logOut = function() {
		authEngine.logOut();
		$rootScope.authStatus=false; 
			
		$location.path('/logIn');   
	 }
	 

	$scope.publishEnabled=true;  

	
	$scope.memberData = {
		memberId: authEngine.memberDetails().memberId,
		memberRole: authEngine.memberDetails().memberRole
	//    unlockedModules: [] 
	};
	

	$scope.searchString;

	
	$scope.refreshData = function(){
		
		$scope.refreshQuotesData = true;
		
		var initializeData = {
			functionType: "initializeQuotesList",
			memberId: $scope.memberData.memberId
		}; 
	 
		$http.post('php/quotesData.php', initializeData) 
		.success(function (data, status, headers, config){
		
			$scope.quotesListData=data[0];       

		    				
			$scope.refreshQuotesData = false;  //to stop refresh icon

		})
		.error(function (data) {   
			swal('',data.message,'error');
		
			$scope.refreshQuotesData = false;   //this is to stop the refresh icon 
		});
	
		 
	}   
	
	$scope.refreshData();   

	
	$scope.enterModule = function (moduleName,quoteNumber) {
		
		
		if(moduleName=='newQuoteTemplate1'){
				
				$location.path('/template1/createNewQuote/quoteNumber');  //for a new quote quoteNumber passed is 0
					
		}else if(moduleName=='editQuoteTemplate1'){
				
				$location.path('/template1/editQuote/'+quoteNumber);  //for a new quote quoteNumber passed is 0      
					
		}else if(moduleName=='deleteQuoteTemplate1'){  
			
			
			swal({
			  title: 'Are you sure?',
			  text: "You won't be able to revert this!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete it!',
			  cancelButtonText: 'No, cancel!',
			  confirmButtonClass: 'btn btn-success',
			  cancelButtonClass: 'btn btn-danger',
			  buttonsStyling: true, 
			  reverseButtons: true
			}).then((result) => {
				if (result.value) {

				$scope.refreshQuotesData=true;
		
				var formData = {
			    	functionType: "processTemplate1QuoteDelete",  
				    memberId: $scope.memberData.memberId,
			        quoteNumber: quoteNumber
					};
					
			
				$http.post('php/quotesData.php', formData)  
				.success(function (data, status, headers, config) { 
						$scope.refreshQuotesData=false;
						$scope.refreshData(); 
					   
			        })
				.error(function (data, status, headers, config) {
					$scope.refreshQuotesData=false;
				    swal('',data.message,'error');
				   
		 	    });
		 	    

			  } else {  
			    
			    //delete is cancelled
			  }
			});  

 	    	
		}		
		
		
	}
	
	
    $scope.publishQuote = function(indx) { 
    	
    	$scope.refreshQuotesData=true;  
    	
    	$scope.publishedCode = Math.floor((Math.random()*10000)+1);
    
        var formData = {
          functionType: "publishQuote",
          quoteNumber: $scope.quotesListData[indx].quoteNumber,    
          memberId: $scope.memberData.memberId,  
          publishedCode: $scope.publishedCode
        };
        
     
    $http.post('php/quotesData.php', formData)  
    .success(function (data, status, headers, config) {
    	$scope.refreshQuotesData=false;
   		$scope.refreshData(); 
    })
    .error(function (data, status, headers, config) {
    	$scope.refreshQuotesData=false;
        swal('',data.message,'error');
        
    });

    }
    
    $scope.unpublishQuote = function(indx) { 
    	
    	$scope.refreshQuotesData=true;  
    	
    
        var formData = {
          functionType: "unpublishQuote",
          quoteNumber: $scope.quotesListData[indx].quoteNumber,    
          memberId: $scope.memberData.memberId
        };
        
     
    $http.post('php/quotesData.php', formData)  
    .success(function (data, status, headers, config) {
    	$scope.refreshQuotesData=false;
   		$scope.refreshData(); 
    })
    .error(function (data, status, headers, config) {
    	$scope.refreshQuotesData=false;
        swal('',data.message,'error');
        
    });

    }    
    
    
 	$scope.shareQuote = function (indx) {

		$scope.refreshQuotesData = true;

	    var formData = {
	    	functionType: "shareQuote",
		    quoteNumber: $scope.quotesListData[indx].quoteNumber,    
        	memberId: $scope.memberData.memberId
		};
		
			
		$http.post('php/quotesData.php', formData)  
		.success(function (data, status, headers, config) {
			$scope.refreshQuotesData = false;
			
			$scope.quoteData = data[0][0];   
			if($scope.quoteData.quoteStatus=='published'){  //use invitationDetails[0] to only take the first row of result

				 var linkToShare = $location.$$absUrl+"viewPublished/"+$scope.quoteData.quoteNumber+"/"+$scope.quoteData.publishedCode;   
			
				$scope.modalInstance=$uibModal.open({   //inject $uibModal in Ctrl
				templateUrl: 'views/modals/shareModal.html',
				controller: 'ShareModalInstanceCtrl',
				size: "md", 
				resolve: {
			    items: function () {
			    	var modalData = [linkToShare];
			     	return modalData;
			    }
			  }   
	
			});

			
			     
		//	    swal('Link to share:','http://quotesmanager.ecrafter.ca/#/viewPublished/'+$scope.quoteData.quoteNumber+'/'+$scope.quoteData.publishedCode); 
	 		}else{  
	 			
	 			swal('',"This quote needs to be published before it can be shared.",'warning');  
	 		}
		})
		.error(function (data, status, headers, config) {
			$scope.refreshQuotesData = false;
		   swal('',data.message,'error');
		
 	    });
	}      
	
	

  
});






