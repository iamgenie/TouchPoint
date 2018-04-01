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
            
              
            case 'initializeQuote':  
                
                $memberId = $mysqli->real_escape_string($data->memberId);  
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber);  
                
                
                $result1 = $mysqli->query("SELECT * FROM Quotes WHERE memberId = '$memberId'  AND quoteNumber = '$quoteNumber'"); 
                $result2 = $mysqli->query("SELECT * FROM Quotes_Texts WHERE memberId = '$memberId'  AND quoteNumber = '$quoteNumber'"); 
                $result3 = $mysqli->query("SELECT * FROM Quotes_Tables WHERE memberId = '$memberId'  AND quoteNumber = '$quoteNumber'");   
                $result4 = $mysqli->query("SELECT * FROM Quotes_Images WHERE memberId = '$memberId'  AND quoteNumber = '$quoteNumber'");   
               

                if($result1){
                    
                    $Quotes_Table=[];
                    while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quotes_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'dateStamp' => $row['dateStamp'],
                            'timeStamp' => $row['timeStamp'], 
                            'quoteId' => $row['quoteId'],
                            'quoteTitle' => $row['quoteTitle'],
                            'quoteStatus' => $row['quoteStatus'],
                            'publishedCodeUsed' => $row['publishedCodeUsed'],
                            'signatureName' => $row['signatureName'],
                            'signatureDateStamp' => $row['signatureDateStamp'],
                            'signatureTimeStamp' => $row['signatureTimeStamp'],  
                            'signatureFileName' => $row['signatureFileName']
                       );
                         
                    };                      
                    
                
                    $Quotes_Text_Table=[];  
                    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quotes_Text_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'quoteText1' => $row['quoteText1'],
                            'quoteTextBackgroundColor1' => $row['quoteTextBackgroundColor1'],   
                            'quoteText2' => $row['quoteText2'],
                            'quoteTextBackgroundColor2' => $row['quoteTextBackgroundColor2'],      
                            'quoteText3' => $row['quoteText3'],
                            'quoteTextBackgroundColor3' => $row['quoteTextBackgroundColor3'],
                            'quoteText4' => $row['quoteText4'],
                            'quoteTextBackgroundColor4' => $row['quoteTextBackgroundColor4']   
                       );
                         
                    };     
                    
                    
                    $Quotes_Tables_Table=[];
                    while ($row = $result3->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quotes_Tables_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'memberId' => $row['memberId'],  
                            'quoteId' => $row['quoteId'],
                            'quoteTableId' => $row['quoteTableId'],
                            'quoteTableColText1' => $row['quoteTableColText1'],
                            'quoteTableColText2' => $row['quoteTableColText2'],
                            'quoteTableColNumber1' => $row['quoteTableColNumber1']
                       );
                         
                    }; 
                    
                   $Quotes_Images_Table=[];
                    while ($row = $result4->fetch_array(MYSQLI_ASSOC)) {  
                        
                        $Quotes_Images_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'imageId' => $row['imageId'],
                            'imageCategory' => $row['imageCategory'],
                            'imageFolder' => $row['imageFolder'],
                            'imageFileName' => $row['imageFileName']
                       );
                         
                    }; 
                    
               
                    echo json_encode(array($Quotes_Table,$Quotes_Text_Table,$Quotes_Tables_Table,$Quotes_Images_Table));  
               
                 
                }else{
                    errorResponse("There seems to be a data issue! Please refresh this page and try again.");
                }
            
            break;
            
            
            case 'initializeImageSelector':  
                
                $memberId = $mysqli->real_escape_string($data->memberId); 
                
                 $result = $mysqli->query("SELECT * FROM Images_Default");   
                 $result1 = $mysqli->query("SELECT * FROM Images_User WHERE memberId = '$memberId'");
                 
                 if($result){
                     
                    $Images_Default_Table=[];
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {  
                        
                        $Images_Default_Table[] = array(
                            'imageId' => $row['imageId'],
                            'imageCategory' => $row['imageCategory'],
                            'imageCaption' => $row['imageCaption'],
                            'imageFolder' => $row['imageFolder'],
                            'imageFileName' => $row['imageFileName'] 
                       );
                         
                    };       
   
                    $Images_User_Table=[];
                    while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {   
                        
                        $Images_User_Table[] = array(
                            'imageId' => $row['imageId'],
                         //   'imageCategory' => '', //     since there is no image category in image user table
                            'dateStamp' => $row['dateStamp'],
                            'timeStamp' => $row['timeStamp'],
                            'imageCaption' => $row['imageCaption'],
                            'imageFolder' => $row['imageFolder'],
                            'imageFileName' => $row['imageFileName']  
                       );
                         
                    };                    
                    
                    
                 echo json_encode(array($Images_Default_Table,$Images_User_Table));     
               
                 
                }else{
                    errorResponse("There seems to be a data issue! Please refresh this page and try again.");
                }
                
                
            break;
            
            case 'processNewQuoteSave':   
                
                $memberId = $mysqli->real_escape_string($data->memberId);
                $quoteData = $data->quoteData;  //to access array do not use real_escape_string 
                $quoteTextsData = $data->quoteTextsData;
                $quoteDetailsTableItems = $data->quoteDetailsTableItems;
                $quoteImagesData = $data->quoteImagesData; 
             //   $assignedStatus = $mysqli-> 'assigned';
               
                $dateStamp = $mysqli->real_escape_string(date('Ymd'));
                $timeStamp = $mysqli->real_escape_string(date('g:i:s a'));  
                

                $quoteId = $quoteData->quoteId; 
                $quoteTitle = $quoteData->quoteTitle;     
                $quoteStatus = 'unpublished';     
                
                
                  
                $insert = $mysqli->query("INSERT INTO Quotes (dateStamp, timeStamp, memberId, quoteId, quoteTitle, quoteStatus)                
                                          VALUES ('$dateStamp', '$timeStamp', '$memberId', '$quoteId', '$quoteTitle', '$quoteStatus')"); 
                
                
                
                if($insert){
                    
                    
                    $select = $mysqli->query("SELECT * FROM Quotes WHERE memberId = '$memberId' AND dateStamp = '$dateStamp' AND timeStamp = '$timeStamp'");   
                    
                    while ($row = $select->fetch_array(MYSQLI_ASSOC)) {
    
                        $Quotes_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'dateStamp' => $row['dateStamp'],
                            'timeStamp' => $row['timeStamp'], 
                            'quoteId' => $row['quoteId'],
                            'quoteTitle' => $row['quoteTitle'],
                            'quoteStatus' => $row['quoteStatus']
                           );
                           
                           $quoteNumber = $row['quoteNumber'];   //to insert into remaining tables
                         
                    };    
                    
                }else{
                        errorResponse("Error saving quote. Please try again!");  
                }  
                
               
                   
                $quoteText1 = $quoteTextsData->quoteText1;   
                $quoteTextBackgroundColor1 = $quoteTextsData->quoteTextBackgroundColor1;    
                $quoteText2 = $quoteTextsData->quoteText2;   
                $quoteTextBackgroundColor2 = $quoteTextsData->quoteTextBackgroundColor2;  
                $quoteText3 = $quoteTextsData->quoteText3;    
                $quoteTextBackgroundColor3 = $quoteTextsData->quoteTextBackgroundColor3; 
                $quoteText4 = $quoteTextsData->quoteText4;    
                $quoteTextBackgroundColor4 = $quoteTextsData->quoteTextBackgroundColor4;
                 
                $insert = $mysqli->query("INSERT INTO Quotes_Texts (quoteNumber, memberId, quoteId, quoteText1, quoteText2, quoteTextBackgroundColor2, quoteText3, quoteTextBackgroundColor3, quoteText4, quoteTextBackgroundColor4)                    
                                          VALUES ('$quoteNumber', '$memberId', '$quoteId', '$quoteText1','$quoteText2', '$quoteTextBackgroundColor2', '$quoteText3', '$quoteTextBackgroundColor3', '$quoteText4', '$quoteTextBackgroundColor4')");       
                
            
               
                if($insert){     
                    
                           
                    }else{
                        errorResponse("Error saving quote text blocks. Please try again!"); 
                }   
                 
              
                //quote details table save logic   
                
                
              //  $delete = $mysqli->query("DELETE FROM Quotes_Tables WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");   
                
                if(count($quoteDetailsTableItems)>0){   //if quote details table has no rows then don't save it
                
                    
                    $valuesArr = array();
                    
                    foreach($quoteDetailsTableItems as $row){
                        
                        $quoteNumber = $quoteNumber; //get quote number from quote data
                        $memberId = $mysqli->real_escape_string($row->memberId);
                        $quoteId = $mysqli->real_escape_string($row->quoteId); 
                        $quoteTableId = $mysqli->real_escape_string($row->quoteTableId);
                        $quoteTableColText1 = $mysqli->real_escape_string($row->quoteTableColText1);
                        $quoteTableColText2 = $mysqli->real_escape_string($row->quoteTableColText2);
                        $quoteTableColNumber1 = $mysqli->real_escape_string($row->quoteTableColNumber1); 
    
                        $valuesArr[] = "('$quoteNumber', '$memberId', '$quoteId', '$quoteTableId' , '$quoteTableColText1' , '$quoteTableColText2' , '$quoteTableColNumber1')"; 
                    } 
                    
                    $valuesArr = implode(',', $valuesArr);
                    
                    $insert = $mysqli->query("INSERT INTO Quotes_Tables (quoteNumber,memberId,quoteId,quoteTableId,quoteTableColText1,quoteTableColText2,quoteTableColNumber1)  
                                               VALUES $valuesArr");     
                            
                    if($insert){    
                        
                               
                        }else{
                            errorResponse("Error saving quote table. Please try again!");  
                    } 
                
                }  
                 
                //end quote details table save logic
                
            
                $valuesArr = array();
                
                foreach($quoteImagesData as $row){
                    
                    $imageId = $mysqli->real_escape_string($row->imageId);
                    $imageCategory = $mysqli->real_escape_string($row->imageCategory);
                    $imageFolder = $mysqli->real_escape_string($row->imageFolder);
                    $imageFileName = $mysqli->real_escape_string($row->imageFileName); 

                    $valuesArr[] = "('$quoteNumber', '$memberId', '$quoteId', '$imageId' , '$imageCategory' , '$imageFolder' , '$imageFileName')"; 
                } 
                
                $valuesArr = implode(',', $valuesArr);
                
                $insert = $mysqli->query("INSERT INTO Quotes_Images (quoteNumber, memberId, quoteId, imageId, imageCategory, imageFolder, imageFileName)              
                                          VALUES $valuesArr");    
                
                  
                    
                if($insert){    
                    
                           
                    }else{
                        errorResponse("Error saving image data. Please try again!"); 
                }    
                
                
               echo json_encode(array($quoteNumber));   //return quote number to refresh data
              
            break;
            

            case 'processEditQuoteSave': 
                
                $memberId = $mysqli->real_escape_string($data->memberId);
                $quoteData = $data->quoteData;  //to access array do not use real_escape_string 
                $quoteTextsData = $data->quoteTextsData;
                $quoteDetailsTableItems = $data->quoteDetailsTableItems;
                $quoteImagesData = $data->quoteImagesData; 
             //   $assignedStatus = $mysqli-> 'assigned';
               
                $dateStamp = $mysqli->real_escape_string(date('Ymd'));
                $timeStamp = $mysqli->real_escape_string(date('g:i:s a')); 
                
                $quoteNumber = $quoteData->quoteNumber; 
                $quoteId = $quoteData->quoteId; 
                $quoteTitle = $quoteData->quoteTitle;    
                  
                $update = $mysqli->query("UPDATE Quotes SET dateStamp = '$dateStamp', timeStamp = '$timeStamp', quoteTitle = '$quoteTitle'               
                                          WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
                   
                
                if($update){ 
                    
                 //   echo json_encode(array($quoteData->quoteNumber));                         
                           
                    }else{
                        errorResponse("Error saving quote title. Please try again!"); 
                } 
                
                $quoteText1 = $quoteTextsData->quoteText1;   
                $quoteTextBackgroundColor1 = $quoteTextsData->quoteTextBackgroundColor1;    
                $quoteText2 = $quoteTextsData->quoteText2;   
                $quoteTextBackgroundColor2 = $quoteTextsData->quoteTextBackgroundColor2;  
                $quoteText3 = $quoteTextsData->quoteText3;    
                $quoteTextBackgroundColor3 = $quoteTextsData->quoteTextBackgroundColor3;   
                $quoteText4 = $quoteTextsData->quoteText4;    
                $quoteTextBackgroundColor4 = $quoteTextsData->quoteTextBackgroundColor4;
                 
                 
                $update1 = $mysqli->query("UPDATE Quotes_Texts SET quoteText1 = '$quoteText1', quoteText2 = '$quoteText2', quoteTextBackgroundColor2 = '$quoteTextBackgroundColor2', quoteText3 = '$quoteText3' , quoteTextBackgroundColor3 = '$quoteTextBackgroundColor3', quoteText4 = '$quoteText4' , quoteTextBackgroundColor4 = '$quoteTextBackgroundColor4'                
                                          WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");
               
                if($update1){  
                    
                           
                    }else{
                        errorResponse("Error saving quote text blocks. Please try again!"); 
                }   
                 
                
                //quote details table save logic   
                
                
                $delete = $mysqli->query("DELETE FROM Quotes_Tables WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");   
                 
                $valuesArr = array();
                
                foreach($quoteDetailsTableItems as $row){
                    
                    $quoteNumber = $mysqli->real_escape_string($quoteData->quoteNumber); //get quote number from quote data
                    $memberId = $mysqli->real_escape_string($row->memberId);
                    $quoteId = $mysqli->real_escape_string($row->quoteId); 
                    $quoteTableId = $mysqli->real_escape_string($row->quoteTableId);
                    $quoteTableColText1 = $mysqli->real_escape_string($row->quoteTableColText1);
                    $quoteTableColText2 = $mysqli->real_escape_string($row->quoteTableColText2);
                    $quoteTableColNumber1 = $mysqli->real_escape_string($row->quoteTableColNumber1);

                    $valuesArr[] = "('$quoteNumber', '$memberId', '$quoteId', '$quoteTableId' , '$quoteTableColText1' , '$quoteTableColText2' , '$quoteTableColNumber1')"; 
                } 
                
                $valuesArr = implode(',', $valuesArr);
                
                $insert = $mysqli->query("INSERT INTO Quotes_Tables (quoteNumber,memberId,quoteId,quoteTableId,quoteTableColText1,quoteTableColText2,quoteTableColNumber1)  
                        VALUES $valuesArr");      
                  
                //end quote details table save logic
                
                
                $delete = $mysqli->query("DELETE FROM Quotes_Images WHERE quoteNumber = '$quoteNumber' AND memberId = '$memberId'");   

                $valuesArr = array();
                
                foreach($quoteImagesData as $row){
                    
                    $imageId = $mysqli->real_escape_string($row->imageId);
                    $imageCategory = $mysqli->real_escape_string($row->imageCategory);
                    $imageFolder = $mysqli->real_escape_string($row->imageFolder);
                    $imageFileName = $mysqli->real_escape_string($row->imageFileName); 

                    $valuesArr[] = "('$quoteNumber', '$memberId', '$quoteId', '$imageId' , '$imageCategory' , '$imageFolder' , '$imageFileName')"; 
                } 
                
                $valuesArr = implode(',', $valuesArr);
                
                $insert = $mysqli->query("INSERT INTO Quotes_Images (quoteNumber, memberId, quoteId, imageId, imageCategory, imageFolder, imageFileName)              
                                          VALUES $valuesArr");    
                
                    
                if($insert){    
                    
                           
                    }else{
                        errorResponse("Error saving image data. Please try again!"); 
                }   
                
         
            break;   
            
            
            
            case 'deleteUserImage':   
                
                $imageFileName = $mysqli->real_escape_string($data->imageFileName);
                
                $imageFilePathAndName = "../img/imgUser/" . $imageFileName;   
               
                
                if(file_exists($imageFilePathAndName)){
                    
                    
                    if (is_writable($imageFilePathAndName)) {
                    
                        unlink($imageFilePathAndName);
                                
                        $delete = $mysqli->query("DELETE FROM Images_User WHERE imageFileName = '$imageFileName'");  
                            
                         if($delete){ 
                             
                            echo json_encode(array($imageFilePathAndName)); 
                            return;
                               
                         }else{
                          errorResponse("Issue updating database. Please try again!"); 
                         }      
                         
                                
                    }else{
                        errorResponse("Issue with deleting this file."); 
                    }
                    
                } else {
                     errorResponse("This file does not exist. Please try again.");  
                }                
                
         
            break;  
            
            case 'viewPublished':    
                
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber);  
                $publishedCode = $mysqli->real_escape_string($data->publishedCode);   
                
                
                $result1 = $mysqli->query("SELECT * FROM Quotes WHERE quoteNumber = '$quoteNumber'"); 
                
                
                if(mysqli_num_rows($result1)){  

                    $Quote_Table=[];
                    while ($row = $result1->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quote_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
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
                            'signatureFileName' => $row['signatureFileName']  
                       );
                         
                    }; 
                    
                    if($Quote_Table[0]['quoteStatus']=='unpublished'){
                        errorResponse("Sorry, this link has expired.");
                        return 0;
                    }
                    if($Quote_Table[0]['publishedCode']!= "$publishedCode"){  
                        errorResponse("Sorry, this link is no longer valid.");   
                        return 0;
                    }                    
      
                   //if link validation passes then load rest of the data..
                
                }else{
                    errorResponse("Sorry, this link is invalid.");
                    return 0;
                }          
                
                   
                
                $result2 = $mysqli->query("SELECT * FROM Quotes_Texts WHERE quoteNumber = '$quoteNumber'"); 
                $result3 = $mysqli->query("SELECT * FROM Quotes_Tables WHERE quoteNumber = '$quoteNumber'");   
                $result4 = $mysqli->query("SELECT * FROM Quotes_Images WHERE quoteNumber = '$quoteNumber'");   
               
                                            
        //        $result4 = $mysqli->query("SELECT * FROM Vendor_Reviews WHERE ratingStatus!='Rejected'");     
          
    
                if($result1){
                    
              
                    $Quote_Text_Table=[];  
                    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quote_Text_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'quoteText1' => $row['quoteText1'],
                            'quoteTextBackgroundColor1' => $row['quoteTextBackgroundColor1'],   
                            'quoteText2' => $row['quoteText2'],
                            'quoteTextBackgroundColor2' => $row['quoteTextBackgroundColor2'],      
                            'quoteText3' => $row['quoteText3'],
                            'quoteTextBackgroundColor3' => $row['quoteTextBackgroundColor3'],
                            'quoteText4' => $row['quoteText4'],
                            'quoteTextBackgroundColor4' => $row['quoteTextBackgroundColor4']         
                       );
                         
                    };     
                    
                    
                    $Quote_Tables_Table=[];
                    while ($row = $result3->fetch_array(MYSQLI_ASSOC)) {
                        
                        $Quote_Tables_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'memberId' => $row['memberId'],  
                            'quoteId' => $row['quoteId'],
                            'quoteTableId' => $row['quoteTableId'],
                            'quoteTableColText1' => $row['quoteTableColText1'],
                            'quoteTableColText2' => $row['quoteTableColText2'],
                            'quoteTableColNumber1' => $row['quoteTableColNumber1']
                       );
                         
                    }; 
                    
                   $Quote_Images_Table=[];
                    while ($row = $result4->fetch_array(MYSQLI_ASSOC)) {  
                        
                        $Quote_Images_Table[] = array(
                            'quoteNumber' => $row['quoteNumber'],
                            'quoteId' => $row['quoteId'],
                            'imageId' => $row['imageId'],
                            'imageCategory' => $row['imageCategory'],
                            'imageFolder' => $row['imageFolder'],
                            'imageFileName' => $row['imageFileName']
                       );
                         
                    }; 
                    
               
                    echo json_encode(array($Quote_Table,$Quote_Text_Table,$Quote_Tables_Table,$Quote_Images_Table));      
               
                   
                }else{
                    errorResponse("There seems to be a data issue! Please refresh this page and try again.");
                }
            
            break;
            
            
            case 'processSignatureSubmit': 
                
                $quoteNumber = $mysqli->real_escape_string($data->quoteNumber);
                $signatureName = $mysqli->real_escape_string($data->signatureName);
                $signatureData = $mysqli->real_escape_string($data->signatureData);
                
               
                $dateStamp = $mysqli->real_escape_string(date('Ymd'));
                $timeStamp = $mysqli->real_escape_string(date('g:i:s a')); 
                
                
             // $data_uri = "data:image/png;base64,iVBORw0K...";
                $encoded_image = explode(",", $signatureData)[1];
                $decoded_image = base64_decode($encoded_image);
                
                $signatureFileName = round(microtime(true)) . '.png';
                file_put_contents("../img/signatures/" . $signatureFileName, $decoded_image);  
                
                
                  
                $update = $mysqli->query("UPDATE Quotes SET signatureName = '$signatureName', signatureDateStamp = '$dateStamp', signatureTimeStamp = '$timeStamp', signatureFileName = '$signatureFileName'            
                                          WHERE quoteNumber = '$quoteNumber'");
                   
                
                if($update){ 
                    
                 //   echo json_encode(array($quoteData->quoteNumber));                         
                           
                    }else{
                        errorResponse("Error saving quote title. Please try again!"); 
                } 
                
            
             
                
         
            break;             
            
            
            
            
             
            default:
                  
            break;
        }

    }

?>

