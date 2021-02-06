<?php
//handles reate note
session_start();
if (!isset($_SESSION['user'])){header('location:home.php');};
//include "header.php";
include '../includes/connect.php';
$note = $_POST['note'];
$user=$_SESSION['user'];


newNotes($conn,$note,$user);
header('location:/notes/note_created.php');

?>
