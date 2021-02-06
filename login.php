<?php
//handles login request
include "includes/connect.php";


if (isset($_POST['login'])){
    $usern = htmlentities(mysqli_real_escape_string($conn,$_POST['username'])) ;
    $pass=htmlentities(mysqli_real_escape_string($conn,$_POST['password'])) ; ;};



loginRequest($conn,$usern,$pass);

?>
