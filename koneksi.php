<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "sql308.infinityfree.com";
$username = "if0_40857713";
$password = "HbmBPOKfUQhUOOB";
$db = "if0_40857713_dailyjournal";

//create connection
$conn = new mysqli($servername,$username,$password,$db);

//check connection
if($conn->connect_error){
    die("Connection failed : ".$conn->connect_error);
}

//echo "Connected successfully<hr>";
?>