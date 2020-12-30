
<?php


echo'<script>
$(document).ready(function(){$("#create_note").click(function(e){
  e.preventDefault(); $("#createNoteDiv").load("/notes/notes_creator.php")});});
 </script>';
echo '<a id=create_note class="btn btn-secondary href="">Create new notes</a>';
echo'<div id="createNoteDiv" ></div>';

session_start();
if (!isset($_SESSION['user'])){header('location:index.php');};
include "../includes/connect.php";
//include "../includes/header.php";

$conn=dataBase_connect();

findNotes($conn);
  echo"</div>";
?>


