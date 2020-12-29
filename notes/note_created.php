<?php 
include "../includes/header.php";
if (!isset($_SESSION['user'])){header('location:/www/home.php');};

include "../header_component.php";
include "../nav_link.php";
echo "<div id='main_container'>";
 echo "<div id='contentDiv'>";
echo"<p id='note_created' class='alert alert-success' >your note has been created </p>";

echo"</div>";echo"</div>";
?>