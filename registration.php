<?php
//handle registration form request
include  "includes/connect.php";
$usern = htmlentities(mysqli_real_escape_string($conn,$_POST['username'])) ;
$pass=htmlentities(mysqli_real_escape_string($conn,$_POST['password'])) ;
$emai=htmlentities(mysqli_real_escape_string($conn,$_POST['email'])) ;
$dob=htmlentities(mysqli_real_escape_string($conn,$_POST['dob'])) ;
$gen=htmlentities(mysqli_real_escape_string($conn,$_POST['gender'])) ;
$first_name = htmlentities(mysqli_real_escape_string($conn,$_POST['firstname'])) ;
$family_name=htmlentities(mysqli_real_escape_string($conn,$_POST['familyname'])) ;
$country=htmlentities(mysqli_real_escape_string($conn,$_POST['country'])) ;
$id=0;
$status="verified";
$posts="no";
if ($gen=="male"){$p_pic="male.png";}else{$p_pic="female.png";};

$desc_user="your description goes here";
$relationship="no relationship information";
if ($gen=="male"){$c_pic="male.png";}else{$c_pic="female.png";};
$recov="recovery message";


registration(
$conn,$usern,$pass,$emai,$dob,$gen,$id,$first_name,$family_name,$country,$status,$posts,$p_pic,$desc_user,$relationship,$c_pic,$recov);

?>