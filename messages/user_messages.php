<?php 
//shows messages of a user
include "../includes/header.php";
$userm= $_GET['message'];

user_messages($userm,$conn);
echo"</div>";
?>