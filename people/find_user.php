<?php
include "../includes/header.php";
$user=$_POST['value'];
findPeople($user,$conn);

?>