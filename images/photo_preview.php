<?php
include "../includes/header.php";
$image_id= $_GET['image_id'];
preview_photo($conn,$image_id);
?>