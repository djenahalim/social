<?php
include "includes/connect.php";
$conn=dataBase_connect();

if (isset($_POST['login'])){
    $usern = htmlentities(mysqli_real_escape_string($conn,$_POST['username'])) ;
    $pass=htmlentities(mysqli_real_escape_string($conn,$_POST['password'])) ; ;};


$conn=dataBase_connect();

loginRequest($conn,$usern,$pass);

?>
