
<?php 
//the page that shows when you are logged in
include "includes/header.php";
include "header_component.php";
include "nav_link.php";
echo "<div id='main_container'>";
 echo "<div id='contentDiv'>";
insert_age($conn,$age);
  echo '<h1>Welcome back  ' . $user. ' !</h1>' ;

include "posts/post_form.php";
echo"</div>";

?>

<body>

</body>

