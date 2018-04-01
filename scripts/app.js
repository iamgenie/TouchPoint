'use strict';


// Declare app level module which depends on views, and components  
var app = angular.module('myApp', ['ngRoute','ngAnimate','ngMessages','ui.bootstrap','ui.utils','angularPayments','angularSpinner']);             
   
app.config(['$routeProvider',  
  function($routeProvider) {
    $routeProvider.  
      when('/logIn', {
        title: 'Log In',
        templateUrl: 'views/logIn.html',   
        controller: 'LogInCtrl',
        access: {
            requiresLogin: false 
        }
      })
      .when('/signUp', {
        title: 'Sign Up',
        templateUrl: 'views/signUp.html',
        controller: 'SignUpCtrl',
        access: {
            requiresLogin: false
        }
      })    
      .when('/purchase', {
        title: 'Purchase',
        templateUrl: 'views/purchase.html',
        controller: 'PurchaseCtrl',    
        access: {
            requiresLogin: false
        }
      })       
      .when('/', {   
        title: 'TouchPoint Home',
        templateUrl: 'views/home.php',  
        controller: 'HomeCtrl',
        access: {
            requiresLogin: true
        }
      })
      
      .when('/template1/:actionType/:quoteNumber', {    
        title: 'Create New Quote',
        templateUrl: 'views/template1.html',    
        controller: 'Template1Ctrl', 
        access: {
            requiresLogin: true
        }
      })
      .when('/template1Preview/:actionType/:quoteNumber', {    
        title: 'Create New Quote',
        templateUrl: 'views/template1Preview.html',    
        controller: 'Template1PreviewCtrl', 
        access: {
            requiresLogin: false 
        }
      }) 
      .when('/:actionType/:quoteNumber/:publishedCode', {    
        title: 'Create New Quote',
        templateUrl: 'views/template1Preview.html',    
        controller: 'Template1PreviewCtrl', 
        access: {
            requiresLogin: false   
        }
      })       
      .when('/help', {
        title: 'Help',
        templateUrl: 'views/help.html',
        controller: 'HelpCtrl',
        access: {
            requiresLogin: false
        }
      }) 
      .otherwise({
        redirectTo: '/'
      });
}]);

app.run(['$location', '$rootScope', function($location, $rootScope, $templateCache) {
  
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
        event.preventDefault(); //to prevent the "confirm form resubmission" dialogue on page refresh
        $rootScope.isRouteLoading = false;  //to stop view change spinner
    });
    
     $rootScope.$on('$routeChangeStart', function(event, next, current) {
        $rootScope.isRouteLoading = true;//to start view change spinner
        
        if(!$rootScope.authStatus){
          if(next.access.requiresLogin){
            $location.path('/logIn');
            $rootScope.isRouteLoading = false; //to stop view change spinner
          }
        }
        
        if (typeof(current) !== 'undefined'){
            $templateCache.remove(current.templateUrl);
        }
        

    });
    
}]);


 app.directive("fileInput", function($parse){  
      return{  
           link: function($scope, element, attrs){    
                element.on("change", function(event){  
                     var files = event.target.files;  
                     //console.log(files[0].name);  
                     $parse(attrs.fileInput).assign($scope, element[0].files);  
                     $scope.$apply();  
                });   
           }  
      }  
 });  
 
  app.directive("blurCurrency", function($filter){  
    
    function link(scope, el, attrs, ngModelCtrl) {

        function formatter(value) {
            value = value ? parseFloat(value.toString().replace(/[^0-9._-]/g, '')) || 0 : 0;
            var formattedValue = $filter('currency')(value);
            el.val(formattedValue);
            
            ngModelCtrl.$setViewValue(value);
            scope.$apply();

            return formattedValue;
      }
      ngModelCtrl.$formatters.push(formatter);

//removed this to prevent input value from reseting to 0 on clicking inside input for first time
   //   el.bind('focus', function() {
  //      el.val('');
  //    });

      el.bind('blur', function() {
        formatter(el.val());
      });
    }  

    return {
      require: '^ngModel',
      scope: true,
      link: link
    };
    
    
 
  
 }); 



app.service('authEngine', function ($q, $timeout,$http) {
  
  this.emailLogIn="";   
	this.passwordLogIn="";
	
	this.nameSignUp="";
	this.phoneSignUp="";  
	this.emailSignUp="";
	this.passwordSignUp="";
	this.memberRole="";

	this.emailResetPassword="";
	this.passwordResetPassword="";
  
  var authStatus=false;
	var memberDetails = {
	    memberId: "",
	    memberName: "",
	    memberEmail: "",
	    memberPhone: "", 
	    memberRole: ""
	};
   
    this.memberDetails = function(){
      return memberDetails;
    }
    this.authStatus = function(){
      return authStatus;
    }
    
    
  this.authenticate = function(){
      
    var deferred = $q.defer();
    
    var formData = {
        functionType: "logIn",
  	    emailLogIn: this.emailLogIn,
  	    passwordLogIn: this.passwordLogIn
  	};


  	$http.post('php/authenticate.php', formData)
  	.success(function (data, status, headers, config){
 			var memberDetailsData = data[0];
 			memberDetails.memberId = memberDetailsData[0].memberId;
			memberDetails.memberName = memberDetailsData[0].memberName;
			memberDetails.memberEmail = memberDetailsData[0].memberEmail;
			memberDetails.memberPhone = memberDetailsData[0].memberPhone;
			memberDetails.memberRole = memberDetailsData[0].memberRole;
			authStatus=true;
			deferred.resolve(memberDetails);
			
  	})
  	.error(function (rejected) { 
      authStatus=false;
      deferred.reject(rejected); 
  	});

  	return deferred.promise;
      
    }
 
  this.signUp = function(){
      
    var deferred = $q.defer();
     
    var formData = {
        functionType: "signUp",
        name: this.nameSignUp,
        phone: this.phoneSignUp,
  	    email: this.emailSignUp,
  	    password: this.passwordSignUp, 
  	    role: this.memberRole
  	};
 
 
  	$http.post('php/authenticate.php', formData)
  	.success(function (data, status, headers, config){
 			var memberDetailsData = data[0];
 			memberDetails.memberId = memberDetailsData[0].memberId;
			memberDetails.memberName = memberDetailsData[0].memberName;
			memberDetails.memberEmail = memberDetailsData[0].memberEmail;
			memberDetails.memberPhone = memberDetailsData[0].memberPhone;
			memberDetails.memberRole = memberDetailsData[0].memberRole;
			authStatus=true;
			deferred.resolve(memberDetails);
			
  	})
  	.error(function (rejected) { 
      authStatus=false;
      deferred.reject(rejected);
  	});

  	return deferred.promise;
      
    }    
    
  this.resetPassword = function(){
      
    var deferred = $q.defer();
    
    var formData = { 
        functionType: "resetPassword",
  	    email: this.emailResetPassword,
  	    password: this.passwordResetPassword
  	};
 
 
  	$http.post('php/authenticate.php', formData)
  	.success(function (data, status, headers, config){
			deferred.resolve();
  	})
  	.error(function (rejected) { 
      authStatus=false;
      deferred.reject(rejected);
  	});

  	return deferred.promise;
      
    }   
    
    
    this.logOut = function(){
      
  	 memberDetails = {
  	    memberId: "",
  	    memberName: "",
  	    memberEmail: "",
  	    memberPhone: "", 
  	    memberRole: ""
  	  };
      
    }


});


