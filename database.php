<?php 
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "find_lost_pan_number_api";
$ahk_conn = mysqli_connect($hostname,$username,$password,$dbname);
if(!$ahk_conn){
    echo "Database Not Connected!";
}

$api_key = ""; // API Key Here

?>