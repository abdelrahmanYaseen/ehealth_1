<?php

header('Access-Control-Allow-Origin: *');
require_once('config.php');

$DBConnection = mysqli_connect($DBSERVER, $DBUSER, $DBPASSWORD, $DBNAME);
mysqli_select_db($DBConnection, $DBNAME);
mysqli_query($DBConnection, "SET NAMES utf8");


$ResultJSON = '{"Operation" : "NoOP", "Result" : "-100" }';
switch ($_REQUEST["Operation"]) {
    case "Login":
        
        $pass=MD5($_REQUEST["Password"]);
        
        $ControlUserSQL = "Select * from user where Username='" . $_REQUEST["Username"] . "' and Password='" . $pass . "'";
        $ControlUser = mysqli_query($DBConnection, $ControlUserSQL);
        
        if (mysqli_affected_rows($DBConnection) > 0) {
            
                $UserID = mysqli_fetch_array($ControlUser);
                
                $ResultJSON = '{"Operation" : "Login", "Result" : "1" , "UserID" : "' . $UserID["UserID"] .'" , "Username" : "' . $UserID["Username"] .'" , "UserType" : "' . $UserID["UserType"] .'" ';
           
            if(($UserID["UserType"] == "Doctor")||($UserID["UserType"] == "Patient"))
            {
                $Query = 'UPDATE chatnotification SET NumberOfMessages=0 WHERE UserID="'.$UserID["UserID"].'"';
                $QueryResult = mysqli_query($DBConnection, $Query);
                //$last_id = mysqli_insert_id($DBConnection);
                //$ResultJSON =$ResultJSON.',"SessionID" : "' . $last_id .'" ';
            }
            $ResultJSON=$ResultJSON."}";
        } else {
            $ResultJSON = '{"Operation" : "Login", "Result" : "-1" }';
        }
// Check result         	  		     
        break;
}


echo $ResultJSON;
?>