<?php
//accepts a friend request
include "../includes/header.php";
$user=$_GET['user'];

accept_friend_request($conn,$user);

?>