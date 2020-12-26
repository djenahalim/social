<?php 
include "../includes/header.php";
if (!isset($_SESSION['user'])){header('location:/www/home.php');};

include "../header_component.php";
include "../nav_link.php";
echo "<div id='main_container'>";
 echo "<div id='contentDiv'>";
echo"<p  class='alert alert-success' > Congratulations! you have just made another friend  !</p>";

echo"</div>";echo"</div>";

?>