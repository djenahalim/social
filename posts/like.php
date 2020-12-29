<?php 
include "../includes/header.php";
echo $_POST["like"];
if (isset($_POST["like"])){
 $id=  $_POST["post_id"] ;
    like($conn,$id);
    echo "done";
    header('location:/www/posts/my_posts.php');
}

?>