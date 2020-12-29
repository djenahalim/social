<?php 
include "../includes/header.php";
if (!isset($_SESSION['user'])){header('location:/home.php');};

include "../header_component.php";
include "../nav_link.php";
echo "<div id='main_container'>";
 echo "<div id='contentDiv'>";
echo"<p  class='alert alert-success' > message sent !</p>";

echo"</div>";echo"</div>";

?>