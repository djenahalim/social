<?php 
include "../includes/header.php";
$userm= $_GET['message'];

user_messages($userm,$conn);
echo"</div>";
?>