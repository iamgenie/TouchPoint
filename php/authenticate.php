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
            case 'logIn':
 
                $emailLogIn = $mysqli->real_escape_string($data->emailLogIn);
                $passwordLogIn = $mysqli->real_escape_string($data->passwordLogIn); 
                
                $select = $mysqli->query("SELECT * FROM Members WHERE memberEmail = '$emailLogIn' AND memberPassword = '$passwordLogIn'");
                
                if(mysqli_num_rows($select)){
                  
                    while ($row = $select->fetch_array(MYSQLI_ASSOC)) {
                    
                        $Member_Details[] = array(
                            'memberId' => $row['memberId'],
                            'memberName' => $row['memberName'],
                            'memberEmail' => $row['memberEmail'],
                            'memberPhone' => $row['memberPhone'],
                            'memberPhone' => $row['memberPhone']
                           );
                     
                    };
                
                    echo json_encode(array($Member_Details));
                
                }else{
                    errorResponse("Invalid Credentials. Please try again.");
                }
                
            break;
                
            case 'signUp':
                
                $memberName = $mysqli->real_escape_string($data->name);
                $memberPhone = $mysqli->real_escape_string($data->phone);
                $memberEmail = $mysqli->real_escape_string($data->email);
                $memberPassword = $mysqli->real_escape_string($data->password); 
                $memberRole = $mysqli->real_escape_string($data->role);
                
                
                $dateStamp = $mysqli->real_escape_string(date('Ymd'));
                $timeStamp = $mysqli->real_escape_string(date('g:i a'));
                 
                $select = $mysqli->query("SELECT * FROM Members WHERE memberEmail = '$memberEmail'");
               
                if(mysqli_num_rows($select)<1){
                    $insert = $mysqli->query("INSERT INTO Members (memberName, memberPhone, dateStamp, timeStamp, memberEmail, memberPassword, memberRole) 
                        VALUES ('$memberName', '$memberPhone', '$dateStamp', '$timeStamp', '$memberEmail', '$memberPassword', '$memberRole')");

                    if($insert){
                        
                        $select = $mysqli->query("SELECT * FROM Members WHERE memberEmail = '$memberEmail'");
                        
                        while ($row = $select->fetch_array(MYSQLI_ASSOC)) {
    
                            $Member_Details[] = array(
                                'memberId' => $row['memberId'],
                                'memberName' => $row['memberName'],
                                'memberEmail' => $row['memberEmail'],
                                'memberPhone' => $row['memberPhone'],
                                'memberRole' => $row['memberRole']
                               );
                               
                               $memberId = $row['memberId'];   //to insert into Member_Modules table
                             
                        };
                        
                        
                        //logic to for module progress percent
                        $valuesArr = array();
                        $memberModules = $data->memberModules;  //to access array do not use real_escape_string
                        
                        foreach($memberModules as &$value){
                            
                            $moduleId = $value;
                            $progressPercent = "0";
                            $valuesArr[] = "('$memberId', '$moduleId', '$progressPercent')"; 
                        }                 
                        
                        $valuesArr = implode(',', $valuesArr);
                               
                        $insert = $mysqli->query("INSERT INTO Member_Modules (memberId,moduleId,progressPercent) 
                        VALUES $valuesArr");                
                        
                        //end logic for module progress percent                        
                        
                        
                        
                        echo json_encode(array($Member_Details,$memberModules));
                        
                    }else{
                        errorResponse("There seems to be a network issue! Please refresh this page and try again.");
                    }                    
                    
                    
                    
                }else{
                    errorResponse("This email address ".$email." has already been used to sign up. You may log in using this email or sign up with another email address."); 
                }
         
            break;

            case 'resetPassword': 
                
                $email= $mysqli->real_escape_string($data->email);
                $password = $mysqli->real_escape_string($data->password); 
                
                $select = $mysqli->query("SELECT * FROM Members WHERE memberEmail = '$email'");
                
                if(mysqli_num_rows($select)){ 
                
                    $update = $mysqli->query("UPDATE Members SET memberPassword = '$password'
                    WHERE memberEmail = '$email'");
              
                    if($update){
    
                    }else{
                        errorResponse("There seems to be a network issue! Please refresh this page and try again.");
                    }                    
                }else{
                    errorResponse("The email address ".$email." does not exist in our system.");
                } 
         
            break;         

            default:
                  
            break;
        }

}



//$mysqli->close();

?>