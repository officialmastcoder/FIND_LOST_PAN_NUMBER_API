<?php 
/**
 * License : GPL (General Public License).
 * Author: AHK WEB SOLUTIONS
 * Company : AHK WEB SOLUTIONS
 * Author-email : admin@ahkwebsolutions.com
 * Author-contact: +1 5395001134
 * Project Name: FIND LOST PAN NUMBER USING API
 * Api Url : https://apizone.in
 */
// Define Database Variables
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "find_lost_pan_number_api";
// conneting database 
$ahk_conn = mysqli_connect($hostname,$username,$password,$dbname);
if(!$ahk_conn){
    echo "Database Not Connected!";
}

// define Api Key
$api_key = ""; // API Key Here
// Define Admin Secret key for submitting data 
$pass = "123";
// generate hash of this secret
$main_secret  = password_hash($pass,PASSWORD_DEFAULT);

?>