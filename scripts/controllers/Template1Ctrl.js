app.controller('Template1Ctrl', function($scope,$rootScope, $q, $http, $route, $routeParams, $filter, $uibModal,  $log, $location, $anchorScroll, authEngine, $sce,$timeout) {           


	if(!authEngine.memberDetails().memberId){
		$location.path('/logIn'); 
	}
	
	$scope.logOut = function() {
		authEngine.logOut();
		$rootScope.authStatus=false; 
		//$scope.loginLogout = "Log In";
		$location.path('/logIn'); 
	 }
	 
	$scope.memberData = {
		memberId: authEngine.memberDetails().memberId,
		memberRole: authEngine.memberDetails().memberRole
	//    unlockedModules: [] 
	};

    var ctrl = this;
    $scope.editorOptions = { 
    					theme: "modern",   
        				inline:true,
        			//	fixed_toolbar_container: '#mytoolbar',     
                        plugins: ['link','code','hr','textcolor','table','paste'],  
                      //  toolbar: ['table','forecolor backcolor']
                     //   statusbar: false,
                       // menubar: false,
                       // resize: false,
                        toolbar: ['fontselect | fontsizeselect | formatselect | forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | undo redo | link | table'],
                    	fixed_toolbar_container: '#mytoolbar', 
                    	font_formats: 'Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;',   
                     
                        fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 36pt 40pt 48pt 60pt 72pt',    
                        
                        //for pasting from word/powerpoint..
                        paste_as_text: true 

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

	if($scope.params.actionType=="editQuote") {     

		$scope.refreshQuotesData = true;

		var initializeData = {
			functionType: "initializeQuote",
			memberId: $scope.memberData.memberId,
			quoteNumber: $scope.params.quoteNumber 
		}; 
		
	
	 
		$http.post('php/template1Data.php', initializeData) 
		.success(function (data, status, headers, config){
		
			$scope.quoteData=data[0][0];  
			$scope.quoteTextsData=data[1][0]; 
			$scope.quoteDetailsTableItems=data[2]; 
			$scope.quoteImagesData=data[3];   
			
			$scope.updateTotalColNumber1(); //to calculate totals

			$scope.refreshQuotesData = false;  //to stop refresh icon

		})
		.error(function (data) {   
			swal('',data.message,'error');
		
			$scope.refreshQuotesData = false;   //this is to stop the refresh icon 
		});
	
	}else{
		  
	    $scope.quoteImagesData.push({
	    	imageId: "3",
	    	imageCategory: "Banner Image",  
	    	imageFolder: "bannerImages",
            imageFileName: "0003.jpg" 
        }); 		
	    $scope.quoteImagesData.push({
	    	imageId: "0",
	    	imageCategory: "Logo Image", 
	    	imageFolder: "common",
            imageFileName: "logoPlaceholder.jpg"  
        });  
        
        
		
		$scope.quoteTextsData.quoteText1='<h1 style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1> <h1 style="text-align: center;"><strong>&nbsp; Quote Heading</strong></h1> <p style="text-align: center;"><span style="color: #ffffff;"><strong>&nbsp;&nbsp;&nbsp;&nbsp; Click to edit<br /></strong></span></p> <p>&nbsp;</p> <p>&nbsp;</p> <p>&nbsp;</p> <p>&nbsp;</p>';
		$scope.quoteTextsData.quoteTextBackgroundColor1="#FFFFFF"; 
		$scope.quoteTextsData.quoteText2='<h1 style="text-align: center;">Text <span style="color: #800080;">Block</span></h1> <p style="text-align: center;">Click to edit.</p> <p>&nbsp;</p> <p>&nbsp;</p> ';
		$scope.quoteTextsData.quoteTextBackgroundColor2="#AAAAAA";
		$scope.quoteTextsData.quoteText3='<h1 style="text-align: center;">Table <span style="color: #800080;">Title</span></h1>';  
		$scope.quoteTextsData.quoteTextBackgroundColor3="#FFFFFF";     
		$scope.quoteTextsData.quoteText4='<h1 style="text-align: center;">Text <span style="color: #800080;">Block</span></h1> <p style="text-align: center;"><span style="color: #800080;">Click to edit.</span></p> <p>&nbsp;</p> <p>&nbsp;</p> <p>&nbsp;</p> ';
		$scope.quoteTextsData.quoteTextBackgroundColor4="#FFFFFF";       
		
	}  
	

	
	$scope.insertItem = function(form) { 
		
	    $scope.quoteDetailsTableItems.push({
	    	memberId: "1001",
	    	quoteId: "template1",
	    	quoteTableId: "table1",
            quoteTableColText1: "",
            quoteTableColNumber1: ""  
        }); 
        
        $scope.updateTotalColNumber1();
      
	    };
	    
	    
    $scope.deleteItem = function(index) {

    	
        $scope.quoteDetailsTableItems.splice(index, 1);
        $scope.updateTotalColNumber1(); 
    };	    
	    
	    
	$scope.updateItem = function(index) { 
	
		var postData={
			 functionType: "updateItem",
			 memberId: authEngine.memberDetails().memberId,
		     moduleId: "wiseLeadership",
		     milestoneStatus: $scope.milestoneItems[index].milestoneStatus,
		     milestoneTitle: $scope.milestoneItems[index].milestoneTitle
		};
			
		$http.post('php/milestonesDataUpdate.php', postData) 
		.success(function (data, status, headers, config){ 
		
			$scope.milestoneItems=data[0];

			$scope.updateCart();
		})
		.error(function (data) {   
			swal('',data.message,'error');
		});
      
	};	


	$scope.TotalColNumber1=0;
	
	$scope.updateTotalColNumber1 = function() {  
	//	$scope.numberOfItemsInCart = $scope.milestoneItems.length;
		
			$scope.TotalColNumber1=0;
			angular.forEach($scope.quoteDetailsTableItems,function(value,key){

	   			//if($scope.numberOfItemsInCart){ //only display cart if calculated distance is > 0
	   				$scope.TotalColNumber1 += (parseFloat(value.quoteTableColNumber1))||0; 
	   			//	value.commission = $scope.commissionPercent*value.totalCost;
	   			//	value.vendorCost = 	value.totalCost - value.commission;

						// price conditions:
						if($scope.TotalColNumber1){
						}else{
							$scope.TotalColNumber1=0;
						}						
						
	   			
	   			
			 });
	}
	     
	
	$scope.openImageSelectorModal = function (imageChangeType) { 

		var modalInstancee = $uibModal.open({   //inject $uibModal in Ctrl
		  templateUrl: 'views/modals/imageSelectorModal.html',
		  controller: 'ImageSelectorModalInstanceCtrl', 
		  size: "md",  
		  resolve: {
		    items: function () {
		    	var modalData = [$scope.memberData,imageChangeType];    
		     	return modalData;
		    }
		  }
		});
			    
			
		modalInstancee.result.then(function (imageData) { 
			
				
			angular.forEach($scope.quoteImagesData,function(value,key){  
				
				if(value.imageCategory==imageChangeType){
					value.imageId= imageData.imageId;
					value.imageCategory= imageChangeType;   //elegant solution to change the right image (banner image/logo image etc..)
					value.imageFolder= imageData.imageFolder;  
					value.imageFileName= imageData.imageFileName;   
					return true;
				}
		    
		    });
			
			  
		}, function () {
		  $log.info('Modal dismissed at: ' + new Date());
		});	
	
	};

	
	$scope.processQuoteSave = function () {   
 	
		 
		$scope.isBusy=true;
			
	  
		
		var formData =[];
		if($scope.quoteData.quoteNumber){
			
			formData = {
	    	functionType: "processEditQuoteSave",
		    memberId: $scope.memberData.memberId,
	        quoteData: $scope.quoteData,
	        quoteTextsData: $scope.quoteTextsData,
	        quoteDetailsTableItems: $scope.quoteDetailsTableItems,
	        quoteImagesData: $scope.quoteImagesData
			};
			
		}else{
	
			formData = {
	    	functionType: "processNewQuoteSave",
		    memberId: $scope.memberData.memberId,
	        quoteData: $scope.quoteData,
	        quoteTextsData: $scope.quoteTextsData,
	        quoteDetailsTableItems: $scope.quoteDetailsTableItems,
	        quoteImagesData: $scope.quoteImagesData		
			};
	
		}

		$http.post('php/template1Data.php', formData)
		.success(function (data, status, headers, config) {
			
			//to load quoteNumber in case of new quote save
			if(formData.functionType=="processNewQuoteSave"){  
			   	$location.path('/template1/editQuote/'+data[0]);  
			   	
			   }    
			   
			   swal('',"Saved!",'success');      
			   $scope.isBusy=false;
	        })
		.error(function (data, status, headers, config) {
		   swal('',data.message,'error');
		   $scope.isBusy=false;
 	    	});
 	    	
 	    	

	}
	   
	
	$scope.processQuoteSaveAs = function () {  
		
		swal({
			  title: 'Save as title', 
			  input: 'text',
			  showCancelButton: true,
			  confirmButtonText: 'Save',
			  showLoaderOnConfirm: true,
			  preConfirm: (text) => {  
			    return new Promise((resolve) => {
			      setTimeout(() => {
			        if (text === '') {
			          swal.showValidationError(
			            'Title is required'
			          );
			        }
			        resolve();
			      }, 200)  
			    })
			  },
			  allowOutsideClick: () => !swal.isLoading()
			}).then((result) => {
				
			if(result.value!=null){   //do nothing if cancel/click outside          
				
				$scope.quoteData.quoteTitle=result.value; //pass new title name from swal to quoteData array
					
				var formData = {
		    	functionType: "processNewQuoteSave",
			    memberId: $scope.memberData.memberId,
		        quoteData: $scope.quoteData,
		        quoteTextsData: $scope.quoteTextsData,
		        quoteDetailsTableItems: $scope.quoteDetailsTableItems,
		        quoteImagesData: $scope.quoteImagesData		
				};	
				
				$http.post('php/template1Data.php', formData)
				.success(function (data, status, headers, config) {
					
					//to load quoteNumber in case of new quote save
					if(formData.functionType=="processNewQuoteSave"){  
					   	$location.path('/template1/editQuote/'+data[0]);  
					   	
					   }    
					    swal({
					      type: 'success',
					      title: 'Saved!',
					      html: 'Title: ' + result.value
					    });     
					   
			        })
				.error(function (data, status, headers, config) {
				   swal('',data.message,'error');
				   $scope.isBusy=false;
		 	    });	
	
			}
			  
		});  
	

	}
	

  

});


app.controller('ImageSelectorModalInstanceCtrl', function ($scope, $http, $filter, $uibModalInstance, items) {
	
	$scope.isBusy=false;//to reset busy cog
	
	$scope.currentTab = "imageCollections"; 
		
	$scope.switchTab = function(selectedTab){
        $scope.currentTab=selectedTab; //important to ensure book/speak modal is shown
    }
    
    var imageChangeType = items[1];
    
    
    $scope.refreshData = function() { 
	

		var initializeData = {
			functionType: "initializeImageSelector",
			memberId: items[0].memberId         
		}; 	
	
	 
		$http.post('php/template1Data.php', initializeData) 
		.success(function (data, status, headers, config){
		
 
			$scope.imagesDefaultData=data[0];   
			$scope.imagesUserData=data[1];   

		    				
			$scope.refreshQuotesData = false;  //to stop refresh icon

		})
		.error(function (data) {   
			swal('',data.message,'error');
		
			$scope.refreshQuotesData = false;   //this is to stop the refresh icon 
		});	
	
    }
    
    $scope.refreshData();


	$scope.processImageChange = function (imgIndx) {
		

				var imageData =[];
				
				if($scope.currentTab == "imageCollections"){  
		        
		        	imageData = $scope.imagesDefaultData[imgIndx]; 
		        	$uibModalInstance.close(imageData); 
				
				}else{ 
					
					imageData = $scope.imagesUserData[imgIndx];    
					$uibModalInstance.close(imageData); 
					
				}
 
	
	}
	
	
      $scope.uploadFile = function(){  
      	
      	$scope.refreshImageSelectorSpinner=true;
          
           var file_data = new FormData();  
           angular.forEach($scope.files, function(file){    
                file_data.append('file', file);  
                file_data.append('memberId', "1001");   
                  
           });  
           $http.post('php/uploadImage.php', file_data,    
           {  
                transformRequest: angular.identity,  
                headers: {'Content-Type': undefined,'Process-Data': false}  
           }).success(function(response){  
                 $scope.refreshData();  
                 $scope.refreshImageSelectorSpinner=false;
            //    $scope.select();  
           }).error(function(response){ 
                alert(response.message);    
                $scope.refreshImageSelectorSpinner=false; 
        });  
      } 
      
      
      $scope.processUserImageDelete = function(imgIndx){  
      	
      	$scope.refreshImageSelectorSpinner=true;
          
		var initializeData = {
			functionType: "deleteUserImage",  
			imageFileName: $scope.imagesUserData[imgIndx].imageFileName 
		}; 	
	
	 
		$http.post('php/template1Data.php', initializeData) 
		.success(function (data, status, headers, config){
		
 
			$scope.refreshData(); 
			
			$scope.refreshImageSelectorSpinner = false;  //to stop refresh icon

		})
		.error(function (data) {   
			swal('',data.message,'error');
		
			$scope.refreshImageSelectorSpinner = false;   //this is to stop the refresh icon 
		});	
		
		
      }       
	

	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel');
	};
  
});




