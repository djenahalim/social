<?php
include "../includes/header.php";
$comment=$_POST["comment"];
$id=$_POST["post_id"];
 add_comment($conn,$id,$comment);
 header('location:/posts/my_posts.php');

?>