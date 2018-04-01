<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" ng-app="myApp" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" ng-app="myApp" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" ng-app="myApp" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" ng-app="myApp" class="no-js"> <!--<![endif]-->

<head>   

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <meta name="description" content="Quote Management App">
  <meta name="author" content="eCrafter Inc. / Toronto Web and Mobile App Solutions">
  <title>TouchPoint - Quote Management Application</title>  
  
  <link rel="shortcut icon" href="favicon.png"> 
  

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
  
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
   <!-- Custom CSS -->
  <link href="styles/app.css" rel="stylesheet">

  <link href="styles/sweetalert2.css" rel="stylesheet" />


  <!--  colour picker for div    -->   
    <link rel="stylesheet" href="styles/angular-colorpicker-dr.css" />  
    <script src="scripts/vendor/angular-colorpicker-dr.js"></script>

   <!--  for signature pad    -->  
   <link rel="stylesheet" type="text/css" href="scripts/style.css">   
  

  <!--[if lt IE 7]>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
  <![endif]-->
  <!-- Fav and touch icons -->
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body  id="pageTop">
	<!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <!-- uses spinner.js and angular-spinner-->
  <span us-spinner="{radius:30, width:8, length: 16, color: 'red'}" spinner-on="isRouteLoading"></span>  
   
  <div ng-view id="wrap"></div>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-route.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-touch.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>  
  <!-- phone mask -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js"></script>  
  
   <!-- spinner -->
  <script src="scripts/vendor/spin.min.js"></script>
  <script src="scripts/vendor/angular-spinner.min.js"></script>
  
  <!--  colour picker for div    -->   
  <script src="scripts/vendor/angular-colorpicker-dr.js"></script>
    
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
  <script src="scripts/vendor/ngclipboard.min.js"></script>     
  
  
  <script src="scripts/app.js"></script>
  <script src="scripts/controllers/ShareModalInstanceCtrl.js"></script>    
  
  <script src="scripts/controllers/HomeCtrl.js"></script>
  <script src="scripts/controllers/LogInCtrl.js"></script>
  <script src="scripts/controllers/SignUpCtrl.js"></script>  
  
  <script src="scripts/controllers/Template1Ctrl.js"></script> 
  <script src="scripts/controllers/Template1PreviewCtrl.js"></script> 
  
  
  <?php include __DIR__.'/php/analyticstracking.php';?>
  
 </body>
</html>
