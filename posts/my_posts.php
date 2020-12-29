<?php 
include "../includes/header.php";
include "../header_component.php";
include "../nav_link.php";
echo "<div id=main_container>";
echo "<div id=contentDiv >";
veiw_posts($conn);
echo "</div>";
echo "</div>";

?>

