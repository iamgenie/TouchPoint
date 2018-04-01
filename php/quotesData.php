<?php
//header("Access-Control-Allow-Origin: *");    enable to allow cross site database server requests
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('America/New_York');

$data = json_decode(file_get_contents("php://input"));

function errorResponse ($messsage) {
  header('HTTP/1.1 500 Internal Server Error');
  die(json_encode(array('message' => $messsage)));
}

#Include the connect.php file
include('../config/connect.php');


if(mysqli_connect_errno()) {
errorResponse("Database connection error!");
}

$functionType = $mysqli->real_escape_string($data->functionType); 
 

if($functionType) {  
        switch($functionType) { 
            
              
            case 'initializeQuotesList':  
                
                $memberId = $mysqli->real_escape_string($data->memberId);    
                
                
                $result1 = $mysqli->query("SELECT * FROM Quotes WHERE memberId = '$memberId'"); 
                $result2 = $mysqli->query("SELECT * FROM Quotes_Texts WHERE memberId = '$memberId'"); 
                $result3 = $mysqli->query("SELECT * FROM Quotes_Tables WHERE memberId = '$memberId'");  
                

                if($result1){
                    
                

                    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quotes_Text_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'quoteText1' => $row['quoteText1'],
                            'quoteText2' => $row['quoteText2'],
                            'quoteText3' => $row['quoteText3'],
                            'quoteText4' => $row['quoteText4']
                       );
                         
                    };     
                    
                    while ($row = $result3->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quotes_Tables_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'quoteTableId' => $row['quoteTableId'],
                            'quoteTableCol1' => $row['quoteTableCol1'],
                            'quoteTableCol2' => $row['quoteTableCol2'],
                            'quoteTableCol3' => $row['quoteTableCol3']
                       );
                         
                    };                     
                      
                     
                     while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {
                         
                        
                        $Quote_Texts=[];
                        foreach($Quotes_Text_Table as $quotesText) {
                                
                            if($quotesText['quoteNumber']==$row['quoteNumber']){
                                  
                                $Quote_Texts[] = array(
                                    'quoteNumber' => $row['quoteNumber'],
                                    'quoteId' => $row['quoteId'],
                                    'quoteText1' => $row['quoteText1'],
                                    'quoteText2' => $row['quoteText2'],
                                    'quoteText3' => $row['quoteText3'],
                                    'quoteText4' => $row['quoteText4']  
                               );
                            }
                        }  
                        
                        $Quotes_Tables=[];
                        foreach($Quotes_Tables_Table as $quotesTable) {
                                
                            if($quotesTable['quoteNumber']==$row['quoteNumber']){
                                  
                                $Quotes_Tables[] = array(
                                    'quoteNumber' => $row['quoteNumber'],
                                    'quoteId' => $row['quoteId'],
                                    'quoteTableId' => $row['quoteTableId'],
                                    'quoteTableColText1' => $row['quoteTableColText1'], 
                                    'quoteTableColText2' => $row['quoteTableColText2'],
                                    'quoteTableColNumber1' => $row['quoteTableColNumber1']
                               );
                            }
                        }                         
                        
                                                     
                        $Quotes_List_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'], 
                            'dateStamp' => $row['dateStamp'],
                            'timeStamp' => $row['timeStamp'],
                            'quoteId' => $row['quoteId'],
                            'quoteTitle' => $row['quoteTitle'],
                            'quoteStatus' => $row['quoteStatus'],
                            'publishedCode' => $row['publishedCode'],
                            'publishedCodeUsed' => $row['publishedCodeUsed'],
                            'signatureName' => $row['signatureName'],
                            'signatureDateStamp' => $row['signatureDateStamp'],
                            'signatureTimeStamp' => $row['signatureTimeStamp'],  
                            'signatureFileName' => $row['signatureFileName'],  
                            'quoteTexts' => $Quote_Texts,  
                            'quoteTables' => $Quotes_Tables   
                            //,
                            //'vendorAssignments' =>$Cart_Items             //cart items for delivery orders
                           );
                         
                        }; 
                
   
                    
      
                    echo json_encode(array($Quotes_List_Table)); 
                    
                   
                 
                }else{
                    errorResponse("There seems to be a data issue! Please refresh this page and try again.");
                }
            
            break;
            
            
            case 'processTemplate1QuoteDelete':   
                
                $memberId = $mysqli->real_escape_string($data->memberId);  
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber);  
                
                $delete = $mysqli->query("DELETE FROM Quotes WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
                $delete = $mysqli->query("DELETE FROM Quotes_Images WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
                $delete = $mysqli->query("DELETE FROM Quotes_Tables WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
                $delete = $mysqli->query("DELETE FROM Quotes_Texts WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'"); 
              
            break;  
            
            case 'publishQuote': 
                
                $memberId = $mysqli->real_escape_string($data->memberId);  
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber); 
                $publishedCode = $mysqli->real_escape_string($data->publishedCode);   
                
                $update = $mysqli->query("UPDATE Quotes SET quoteStatus = 'published', publishedCode = '$publishedCode' 
                                          WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
                             
                if($update){ 
                    
                    echo json_encode(array($quoteNumber)); 
                       
                 }else{
                  errorResponse("Issue with updating to Vendor Assignments table."); 
                 }     
                
         
            break;             

            case 'unpublishQuote':  
                
                $memberId = $mysqli->real_escape_string($data->memberId);  
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber); 
                
                $update = $mysqli->query("UPDATE Quotes SET quoteStatus = 'unpublished' 
                                          WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
                             
                if($update){ 
                   
                       
                 }else{
                  errorResponse("Issue with updating to Vendor Assignments table."); 
                 }     
                
         
            break; 
            
            case 'shareQuote':  
                
                $memberId = $mysqli->real_escape_string($data->memberId);  
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber); 
                
                $result = $mysqli->query("SELECT * FROM Quotes WHERE memberId = '$memberId'  AND quoteNumber = '$quoteNumber'");  
   
                if($result){
                    
                    $Quote_Table=[];
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quote_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'dateStamp' => $row['dateStamp'],
                            'timeStamp' => $row['timeStamp'], 
                            'quoteId' => $row['quoteId'],
                            'quoteStatus' => $row['quoteStatus'],
                            'publishedCode' => $row['publishedCode'],
                            'publishedCodeUsed' => $row['publishedCodeUsed']
                       );
                         
                    };                      
                                        
                    
                    echo json_encode(array($Quote_Table)); 
                    
                   
                 
                }else{
                    errorResponse("There seems to be a data issue! Please refresh this page and try again.");
                }
            
            break;

 
            
    
            
     
            default:
                  
            break;
        }

    }

?>

