
<?php
//handles send message
session_start();
include("../includes/connect.php");
$to=$_POST['to'];
$message=$_POST['the_message'];
$id=0;

  messageSending($conn,$to,$message,$id);

  

 ?>