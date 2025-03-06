<?php
$host = "localhost";
$user = "rra-2408c";
$password = "sK(orrB77UqlISlP";
$db_name = "fitforfun";
$con = mysqli_connect($host , $user , $password , $db_name);
if(mysqli_connect_errno()){
die("Failed to connect with MySQL :".mysqli_connect_errno());
}
?>