app.controller('Template1PreviewCtrl', function($scope, $q, $http, $route, $routeParams, $filter, $uibModal, $log, $location, $anchorScroll, authEngine, $sce,$timeout) {

    var ctrl = this;
    $scope.editorOptions = { 
        				inline:true,
                        plugins: ['link','code','hr','textcolor','table'],  
                      //  toolbar: ['table','forecolor backcolor']
                     //   statusbar: false,
                       // menubar: false,
                       // resize: false,
                        toolbar: ['formatselect | forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | undo redo | link | table'],
                        readonly: true

                    };
                    

    this.updateHtml = function() {
      ctrl.editorHtml = $sce.trustAsHtml(ctrl.editor);
    };
    

	$scope.quoteData={
		quoteTitle:"",  
		quoteId:"template1" 
		};  
	$scope.quoteTextsData={   
		quoteText1:"",
		quoteTextBackgroundColor1:"",
		quoteText2:"",  
		quoteTextBackgroundColor2:"", 
		quoteText3:"",
		quoteTextBackgroundColor3:"",    
		quoteText4:"",
		quoteTextBackgroundColor4:""  
		}; 
	
 	$scope.quoteDetailsTableItems=[];  
	   
		  
	$scope.quoteImagesData=[];

 
	$scope.params = $routeParams;
	
	

	
	$scope.refreshData = function() { 
		
		var initializeData = [];
	
	
		if($scope.params.actionType=="previewQuote") {     
			
			
			$scope.refreshQuotesData = true;
			
			 initializeData = {
				functionType: "initializeQuote",
				memberId: $scope.memberData.memberId,
				quoteNumber: $scope.params.quoteNumber 
			}; 
			
		
		 
			$http.post('php/template1Data.php', initializeData) 
			.success(function (data, status, headers, config){
				$scope.refreshQuotesData = false;  //to stop refresh icon
			
				$scope.quoteData=data[0][0];  
				$scope.quoteTextsData=data[1][0]; 
				$scope.quoteDetailsTableItems=data[2]; 
				$scope.quoteImagesData=data[3];  
				
				$scope.updateTotalColNumber1(); //to calculate totals
	
			})
			.error(function (data) {  
				$scope.refreshQuotesData = false;  //to stop refresh icon
				
				swal('',data.message,'error');
				
			});
		
		}else if($scope.params.actionType=="viewPublished"){ 
			
			$scope.refreshQuotesData = true;
			
			
			 initializeData = {
				functionType: "viewPublished",
				quoteNumber: $scope.params.quoteNumber,
				publishedCode: $scope.params.publishedCode
			}; 
			
	
			$http.post('php/template1Data.php', initializeData) 
			.success(function (data, status, headers, config){
				
				$scope.refreshQuotesData = false;  //to stop refresh icon
			
				$scope.quoteData=data[0][0];        
				$scope.quoteTextsData=data[1][0]; 
				$scope.quoteDetailsTableItems=data[2]; 
				$scope.quoteImagesData=data[3]; 
				
				$scope.updateTotalColNumber1(); //to calculate totals
	
			})
			.error(function (data) {   
				$scope.refreshQuotesData = false;   //this is to stop the refresh icon 
				
				swal('',data.message,'warning');
			
				
			});		
			  
	
			
		}else {
			
				$location.path('#/');
			
		} 
		
		  
	}
	
	$scope.refreshData();


	$scope.TotalColNumber1=0;
	
	$scope.updateTotalColNumber1 = function() {  

			$scope.TotalColNumber1=0;
			angular.forEach($scope.quoteDetailsTableItems,function(value,key){

	   				$scope.TotalColNumber1 += (parseFloat(value.quoteTableColNumber1))||0; 
						// price conditions:
						if($scope.TotalColNumber1){
						}else{
							$scope.TotalColNumber1=0;
						}						
   			
			 });
	}
	     
   
	
	
	$scope.signatureData="";
	
	$scope.processSignatureSubmit = function () { 
		
		if($scope.signatureData==""){
        	swal('','Your signature is required','warning');  
        	return 0;  
    	}else if(!$scope.quoteData.signatureName){  
        	swal('','Your name is required','warning');  
        	return 0;  
    	}    	   
		
		$scope.refreshQuotesData=true;  
		
		var formData = {
			
	    	functionType: "processSignatureSubmit", 
		    quoteNumber: $scope.quoteData.quoteNumber,
	        signatureName: $scope.quoteData.signatureName,
	        signatureData: $scope.signatureData  
			}; 
			
		$http.post('php/template1Data.php', formData)
		.success(function (data, status, headers, config) {
			
			$scope.refreshQuotesData=false;
			swal('',"Submitted. Thank you!",'success');    
			$scope.refreshData();   
			   
	        })
		.error(function (data, status, headers, config) {
		   swal('',data.message,'error');
		   $scope.refreshQuotesData=false;
 	    	});			
			
		
			
	}
	


});
