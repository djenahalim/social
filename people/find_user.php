<?php
//handles finding a user using the search bar
include "../includes/header.php";
$user=$_POST['value'];
findPeople($user,$conn);

?>