
  	
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >     

   <div class="navbar-header"> 
   
             <button type="button" class="navbar-toggle" ng-click="isNavCollapsed = !isNavCollapsed">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

	    <a class="navbar-brand" href="#/" ><i class="logoIcon fab fa-houzz fa-2x"></i></a>  
 
    </div>	
    
   <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pull-right">   
    

    
		<div class="collapse navbar-collapse" uib-collapse="isNavCollapsed">
			<ul class="nav navbar-nav navbar-right text-center">  
			<li>
			             <a 
          
           href="#/" 
           ng-click="logOut();" 
           ng-if="authStatus">
            <i class="fas fa-sign-out-alt"></i>
	        		 <br />
	        		 Log out  
          </a> 

        </li>
        

			</ul>
		</div>   
		
		
		</div> 
		
		


</nav>
  
  
  
  
  
  
  
  