<?php 
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "find_lost_pan_number_api";
$ahk_conn = mysqli_connect($hostname,$username,$password,$dbname);
if(!$ahk_conn){
    echo "Database Not Connected!";
}

$api_key = "ijij88787"; // API Key Here
$pass = "123";
$main_secret  = password_hash($pass,PASSWORD_DEFAULT);

?>