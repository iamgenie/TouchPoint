app.controller('LogInCtrl', function($rootScope, $scope, $http, $modal, $log, $location, authEngine) {

	$scope.loginLogout = "Log In";
	$scope.currentForm = "logInForm"; 
	
	$scope.emailLogIn;
	$scope.passwordLogIn; 
	
	$scope.nameSignUp;
	$scope.phoneSignUp;  
	$scope.emailSignUp;   
	$scope.passwordSignUp;
	
	$scope.emailResetPassword;
	$scope.passwordResetPassword;

	$rootScope.authStatus = false;
 

	$scope.switchForm = function(selectedForm){
        $scope.currentForm=selectedForm;
    }

	//for purchase form
	if($scope.memberRole=='newSignUp'){
		$scope.switchForm('purchaseForm');
	}



    $scope.processLogInForm = function(form) {
    	
    	$scope.submittedLogInForm = true; 

        if(form.$invalid){   
        	swal('','Please fill in all the required fields.','error');
        	return;
        } 

		
		authEngine.emailLogIn = $scope.emailLogIn;
		authEngine.passwordLogIn = $scope.passwordLogIn; 

		authEngine.authenticate()
		.then(function(resolved){
			 swal('','Hello '+resolved.memberName+', welcome back!','success');

			 if(resolved.memberRole=='newSignUp'){
			 	$scope.loginLogout = "Log Out";
			 	$rootScope.authStatus = true;
			 	$scope.memberName = resolved.memberName;
			 	$scope.memberRole = resolved.memberRole;
			 	$scope.switchForm('purchaseForm');
			 }else{
			 	$scope.loginLogout = "Log Out";
			 	$rootScope.authStatus = true;
			 	$scope.memberName = resolved.memberName;
			 	$scope.memberRole = resolved.memberRole;			 	
			 	$location.path('#/home');
			 }
			 
			 
		},function(rejected){
			swal('',rejected.message,'error');
		});

	}
	
	$scope.processSignUpForm = function(form) {
		
    	$scope.submittedSignUpForm = true; 

        if(form.$invalid){
        	swal('','Please fill in all the required fields.','error');
        	return;
        } 
		
		authEngine.nameSignUp = $scope.nameSignUp;
		authEngine.phoneSignUp = "6471112222";
		authEngine.emailSignUp = $scope.emailSignUp;
		authEngine.passwordSignUp = $scope.passwordSignUp;
	//	authEngine.memberModules = ['wiseLeadership', 'ethicalLeadership', 'resilientLeadership'];
		
		
		authEngine.signUp()
		.then(function(resolved){
			 swal('','Hello '+resolved.memberName+', welcome!','success');
			 
			 if(resolved.memberRole=='newSignUp'){
			 	$scope.loginLogout = "Log Out";
			 	$rootScope.authStatus = true;
			 	$scope.memberName = resolved.memberName;
			 	$scope.memberRole = resolved.memberRole;
			 	$scope.switchForm('purchaseForm');
			 }else{
			 	$scope.loginLogout = "Log Out";
			 	$rootScope.authStatus = true;
			 	$scope.memberName = resolved.memberName;
			 	$scope.memberRole = resolved.memberRole;			 	
			 	$location.path('#/home');
			 }

		},function(rejected){
			swal('',rejected.message,'error');
		});

	
	}		

	$scope.processResetPasswordForm = function(form) {
		
    	$scope.submittedResetPasswordForm = true; 

        if(form.$invalid){
        	swal('','Please fill in all the required fields.','error');
        	return;
        } 		
		
		authEngine.emailResetPassword = $scope.emailResetPassword;
		authEngine.passwordResetPassword = $scope.passwordResetPassword;
		
		authEngine.resetPassword()
		.then(function(resolved){
		 swal('','Your password has been reset. Please use the new password to log in.','success');
		 $rootScope.authStatus = authEngine.authStatus();
		 $scope.loginLogout = "Log In";
		 $location.path('#/logIn'); 
	
		},function(rejected){
			swal('',rejected.message,'error');
		});
		
	}
	
	
	 $scope.logOut = function() {
		authEngine.logOut();
		$rootScope.authStatus=false; 
		$scope.loginLogout = "Log In";
	 }
	 
  
});



