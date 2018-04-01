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


//  5MB maximum file size 
$MAXIMUM_FILESIZE = 5 * 1024 * 1024;   

$rEFileTypes = "/^\.(jpg|jpeg|gif|png){1}$/i"; 
  
  
    if($_FILES['file']['size'] < $MAXIMUM_FILESIZE) { //5 MB (size is also in bytes)
       
    }else{
         // File too big
        errorResponse("Unable to upload this file. File size should be less than 5 MB");
        return;
    } 
  

 //$memberId = $mysqli->real_escape_string($data->memberId);
 
     $temp = explode(".", $_FILES["file"]["name"]);
     $imageFileName = round(microtime(true)) . '.' . end($temp);
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "../img/imgUser/" . $imageFileName)) {  
     
        $dateStamp = $mysqli->real_escape_string(date('Ymd')); 
        $timeStamp = $mysqli->real_escape_string(date('g:i:s a'));  
        
        $imageCaption = 'User Uploaded Image';
        $imageFolder = "imgUser";
        
        $memberId = $_POST["memberId"];    
        
         
        $insert = $mysqli->query("INSERT INTO Images_User (dateStamp, timeStamp, memberId, imageCaption, imageFolder, imageFileName)              
                                               VALUES ( '$dateStamp', '$timeStamp', '$memberId', '$imageCaption', '$imageFolder', '$imageFileName')");    
                   
        if($insert){       
            
            echo json_encode(array($_POST["memberId"]));        
                   
            }else{
                errorResponse("Error uploading this image. Please try again!"); 
        }     
     
     
      
                
    }else{
        errorResponse("Unable to save. Please try again.");
        
  };    

      
 
 ?>  

