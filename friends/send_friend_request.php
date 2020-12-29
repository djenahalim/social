<?php 
include "../includes/header.php";
$user=$_GET['user'];
send_friend_request($conn,$user);
?>