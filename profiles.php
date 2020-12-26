<?php 
$userp= $_GET['user'];
include "includes/header.php";
include "header_component.php";
include "nav_link.php";
echo"<div id='contentDiv'>";
veiwProfile($conn,$userp);

echo"</div>";
?>