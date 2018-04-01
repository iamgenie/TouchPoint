  <!-- Navigation --> 
	<?php include '../views/00_homeHeader.php';?>  
	
	<span us-spinner="{radius:30, width:8, length: 16}" spinner-on="refreshQuotesData"></span> 
	  
	
	
	

<div class="container">
    <div class="section-heading col-lg-12 col-md-12 col-s-12 col-xs-12">
        <h2></h2>
    </div> 
 <!-- style="background: url('img/home/landingBanner3.jpg') no-repeat; background-size:100%;height:660px;" -->   
    <div class="col-lg-12 col-md-12 col-s-12 col-xs-12" ng-if="!authStatus">     
    
    <h1 class="text-center">TouchPoint</h1>
    
    <!--
    
    <h2 class="text-center">  
       <b><typer words="['Wise Leadership', 'Ethical Leadership', 'Resilient Leadership']" type-time='150' backspace-time='300' start-delay='1500' pause='3000' highlight-background='#033C73'></typer></b>
    </h2>
      
    -->
      
    <hr /><br>
    
        <div class="col-md-4 col-sm-4 col-xs-12">
        </div>
        <!--
        <div class="col-md-4 col-sm-4 col-xs-12">
            <a href="#/signUp" class="btn btn-primary inverse" style="width:100%">
                <h2>Sign Up</h2> 
            </a>
        </div>
        -->
        <div class="col-md-4 col-sm-4 col-xs-12">
        </div>        
        <br>
        <div class="col-lg-12 col-md-12 col-s-12 col-xs-12 text-center">
        <br />
        </div>
        <br> 
        <div class="col-md-4 col-sm-4 col-xs-12">
        </div>        
        <div class="col-md-4 col-sm-4 col-xs-12">
            <a href="#/logIn" class="btn btn-primary active" style="width:100%">
                <h2>Log In</h2> 
            </a>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
        </div>
        <!--
        <div class="col-md-12 col-sm-12 col-xs-12"  style="background: url('img/home/landingBanner.png') no-repeat top center; background-size:90%; min-height:500px; margin-top:50px;">    
        </div>          
        -->  
    
    </div> <!-- end landing part if not signed in -->
    
    <div class="col-lg-12 col-md-12 col-s-12 col-xs-12" ng-if="authStatus">   
    
 
	

	<div class="row">
	</div>   
	
	
  	<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">    
 
      	    <p></p>  
      	</div> 
   	
  
  
  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
  	
  	    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
  	        
    	  	    <a 
    	  	    type="button"
      	  	    href=""
      		    	ng-click="enterModule('newQuoteTemplate1','0');"  
      		    	class="btn btn-primary"
      		    	style="width: 100%;">
      	  	    	
      	  	    	<i class="fas fa-plus fa-lg"></i> 
      	  	    	
      	  	    	&nbsp;&nbsp;New Quote
      	  	    	
      		    </a>
      		    
      		    <p></p> 
      		    
  	     </div>
  	     
   	    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
  	        
    	  	    <a 
    	  	    type="button"
      	  	    href=""
      		    	ng-click="refreshData();"    
      		    	class="btn btn-primary"
      		    	style="width: 100%;">
      	  	    	
      	  	    	<i class="fas fa-sync fa-lg"></i> 
      	  	    	
      	  	    	&nbsp;&nbsp;Refresh
      	  	    	
      		    </a>
      		    
      		    <p></p> 
      		    
  	     </div>
  	     
      	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
      	    <div class="input-group">
      	    	
      	    		<span class="input-group-addon"><i class="fa fa-search fa-lg"></i></span>   
      	    	
                  <input 
                      placeholder="Search ..." 
                      class="form-control input-md"   
                      ng-model="searchString" 
                      autocomplete="off" 
                      type="text">   
              </div>	
              <p></p>
        	</div>
 
 
 </div>
 


	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
	
	

	
		<div class="panel panel-default" ng-if="filteredQuotesListData.length=='0'">
			<div class="panel-body">
	    		<h4>No quotes to show.</h4> 
	    		
	    		<!--
	    	<button type="button"
		    	ng-click="enterModule('createTemplate1');"   
		    	class="btn btn-default btn-md" 
		    	style="width: 100%;">
	  	    	<i class="fa fa-file-text"
	  	    	   ng-class="{'fa-spin':refreshQuotesData==true}">  
	  	    	</i>
	  	    	&nbsp;&nbsp;New Project
		    </button>
		       
		    	-->   
	    		
	    	</div>
	    </div> 
	    
	    
	<div class="panel panel-default" ng-repeat="quoteRequest in filteredQuotesListData = (quotesListData   | filter:dateRangeFilter() | filter: searchString | orderBy : quoteRequest.orderNumber : reverse)">       	
			    <div class="panel-body" ng-class="{signedQuoteList:quoteRequest.signatureFileName}">      
			    
			    
			    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"> 

			    	<a 
			    	    ng-if="!quoteRequest.signatureFileName"
			    		href=""
			    		ng-click="enterModule('editQuoteTemplate1',quoteRequest.quoteNumber);">              
			    		
				    	<h2>{{quoteRequest.quoteTitle}} </h2>     
				    </a>  
				   <i ng-if="!quoteRequest.signatureFileName">Last Updated On: {{quoteRequest.dateStamp | date:'EEE, d MMMM, yyyy'}} at {{quoteRequest.timeStamp}}</i>
				   
			    	<a 
			    	    ng-if="quoteRequest.signatureFileName"
			    		href="#/template1Preview/previewQuote/{{quoteRequest.quoteNumber}}"   
				        target="_blank">              
			    		
				    	<h2>{{quoteRequest.quoteTitle}} </h2>     
				    </a> 				   
				   <i ng-if="quoteRequest.signatureFileName">Signed by <b>{{quoteRequest.signatureName}}</b> on {{quoteRequest.dateStamp | date:'EEE, d MMMM, yyyy'}}</i>
					
			  	
				
				</div>	
				
			    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">   
			    	<p></p>
			    	
			    	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-center">    
			    	
						<a 
						    ng-if="!quoteRequest.signatureFileName"
      	  	                href=""
			    		    ng-click="enterModule('editQuoteTemplate1',quoteRequest.quoteNumber);" 
							style="width: 100%;"> 
							<i class="fas fa-edit fa-lg"></i>      
							<br /><small>Edit</small>
							
						</a>
						<p></p>   
					</div>			    	
			    
			    	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-center">   
        
        				<a 
        				    ng-if="!quoteRequest.signatureFileName"
      	  	                href="#/template1Preview/previewQuote/{{quoteRequest.quoteNumber}}"   
				            target="_blank"
							style="width: 100%;"> 
							<i class="fas fa-eye fa-lg"></i>     
							<br /><small>Preview</small>
							
						</a>
						<p></p>
	
					</div>
					 
					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6  text-center"> 
						  
						<a 
      	  	                href=""
      	  	                ng-if="quoteRequest.quoteStatus=='unpublished'"
							ng-click="publishQuote(quotesListData.indexOf(quoteRequest));"   
							style="width: 100%;">
						    
							<i class="far fa-square fa-lg"></i>   
							<br />
							<small >Publish</small>
						</a>
						
						<a 
      	  	                href=""
      	  	                ng-if="quoteRequest.quoteStatus=='published'"
							ng-click="unpublishQuote(quotesListData.indexOf(quoteRequest));" 
							style="width: 100%;">
						    
							<i class="far fa-check-square fa-lg"></i>  
							<br />
							<small>Unpublish</small>
						</a>
						
						<p></p>

					</div>
					
					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-center"> 
					
					<a 
      	  	            href=""
						ng-click="shareQuote(quotesListData.indexOf(quoteRequest));"        
						style="width: 100%;">
						<i class="fas fa-share-alt-square fa-lg"></i> 
						<br /><small>Share</small>
					</a>					
						<p></p>
					</div>
					
					<!--
					
					<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">   
					
					<a 
						type="button"
						ng-click="openVendorAssignmentModal(quotesListData .indexOf(quoteRequest));"
						style="width: 100%;"
						class="btn btn-primary btn-md"> 
						<i class="far fa-copy fa-2x"></i> 
						<br />Clone
					</a>
						<p></p>  
					</div>
					
					-->
					 
					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 text-center">    
					
					<a 
						href="" 
						ng-click="enterModule('deleteQuoteTemplate1',quoteRequest.quoteNumber);"      
						style="width: 100%;"> 
						<i class="far fa-trash-alt fa-lg"></i> 
						<br /><small>Delete</small>
					</a>
						<p></p>
					</div>  
					
		
				</div>
						    

<!--				
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
				
					<table class="table table-bordered">
						<thead>
							<tr>
								<th colspan="2">From {{quoteRequest.leadOriginName}} ({{quoteRequest.leadOriginId}})</th>
							</tr>
						</thead>						
						<tbody>
							<tr>
							    <td><i class="fa fa-user"></i></td>
							    <td class="text-success">{{quoteRequest.leadName}}</td>
							</tr>
							<tr>
							    <td><i class="fa fa-phone"></i>&nbsp;</td>
							    <td class="text-success">{{quoteRequest.leadPhone}}</td>
							</tr>							 
							<tr>
							    <td><i class="fa fa-envelope"></i>&nbsp;</td>
							    <td class="text-success"><a href="mailto:{{quoteRequest.leadEmail}}">{{quoteRequest.leadEmail}}</a></td>
							</tr>
						</tbody>
					</table>
					
				</div>
				

-->   				
				
				
				
			</div>
			</div>
	    
	   
			   
	    </div>
	    
 
 
 
 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     <!-- 

        <div class="col-md-4 col-sm-4 col-xs-12">
        <span style="color:white;" ng-show="!accessWiseLeadership"><i class="fa fa-file fa-2x pull-left"></i></span>  
        <a href=""  ng-click="enterModule('createTemplate1');" class="thumbnail teal text-center">
            <span class="fa fa-file"></span>
            <h2>Create New Quote</h2>  
            <p>from Template</p>
            <span ng-show="!accessWiseLeadership">
                Purchase
            </span>
            <span ng-show="accessWiseLeadership">
                <br>
            </span>
        </a>
        
     

        <uib-progressbar ng-if="authStatus" animate="true" value="progressPercentWise" class="progressHub" type="success"><i>&nbsp;{{progressPercentWise}}%&nbsp;complete</i></uib-progressbar>
	  
        </div>
       
      
       
        <div class="col-md-4 col-sm-4 col-xs-12">
            <span style="color:white;" ng-show="!accessEthicalLeadership"><i class="fa fa-search fa-2x pull-left"></i></span>
            <a href="" ng-click="enterModule('ethicalLeadership');" class="thumbnail indigo text-center"> 
                <span class="fa fa-search-scale"></span>
                <h2>Search Quotes</h2>
                <p>Previously Created</p>
                <span ng-show="!accessEthicalLeadership">
                    Purchase
                </span>   
                <span ng-show="accessEthicalLeadership">
                    <br>
                </span>            
            </a>
            
            <!--
            <uib-progressbar ng-if="authStatus" animate="true" value="progressPercentEthical" class="progressHub" type="success"><i>&nbsp;{{progressPercentEthical}}%&nbsp;complete</i></uib-progressbar>
            
            
        </div>
        -->
        
        
        <!--
        <div class="col-md-4 col-sm-4 col-xs-12"> 
            <span style="color:white;" ng-show="!accessResilientLeadership"><i class="fa fa-lock fa-2x pull-left"></i></span> 
            <a href="" ng-click="enterModule('resilientLeadership');" class="thumbnail orange text-center">
                <span class="fa fa-shield"></span>
                <h2>Resilient Leadership</h2>
                <p>by Dr. Jennifer Moss</p>
                <span ng-show="!accessResilientLeadership"> 
                    Purchase
                </span>     
                <span ng-show="accessResilientLeadership">
                    <br>
                </span>             
            </a>
            <uib-progressbar ng-if="authStatus" animate="true" value="progressPercentResilient" class="progressHub" type="success"><i>&nbsp;{{progressPercentResilient}}%&nbsp;complete</i></uib-progressbar>
                 
        </div>
        
        <div class="col-md-4 col-sm-4 col-xs-12">
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <a href="" ng-click="enterModule('feedback');" class="btn btn-primary" style="width:100%">
                <span class="fa fa-refresh fa-3x" ></span>
                <h2>360 Feedback</h2> 
            </a>
        </div>
         <div class="col-md-4 col-sm-4 col-xs-12">
        </div>        
        
        -->
    
    </div> <!-- end modules -->


</div>  <!-- end container -->
<br>
  
<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <div class="container">  

        
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="logoSection">
                <a class="logo" href="http://ecrafter.ca">
                    <img class="pull-left" src="img/common/eCrafter_powered_by.png"></img>
                </a> 
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            
            <!--
            <div class="logoSection text-center">
                <a href="" ng-click="openModal('md','legal');">
                    Legal
                </a> 
            </div>
            -->
            
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="logoSection">
                <a class="logo" href="http://globalleader.ca">
                    <img class="pull-right" src="img/common/logo_nav.png"></img>
                </a>        

            </div>

        </div>

    </div>
</nav>

<script>
    var clip = new Clipboard('.btn');

clip.on('success', function(e) {
    $('.copied').show();
		$('.copied').fadeOut(1000);
});
</script>

<?php include __DIR__.'/php/analyticstracking.php';?>