<?php
include "../includes/header.php";

if (isset($_POST['submitp'])){

    $file=$_FILES['file'];
    $file_name=$file['name'];
    $file_Tmp_name=$file['tmp_name'];
    $file_size=$file['size'];
    $file_error=$file['error'];
    $file_type=$file['name'];   
    $file_ext=explode('.',$file_name);
    $file_actual_ext=strtolower(end($file_ext));
    $allowed=array('jpg','jpeg','png');
    if (in_array($file_actual_ext,$allowed)){
     if ($file_error===0){
         if($file_size<10000000){
       $file_new_name=uniqid('',true).".".$file_actual_ext;
       $file_destination='uploads/'.$file_new_name;
       upload_photo($file_new_name,$conn);
       move_uploaded_file($file_Tmp_name,$file_destination);
   
         }
         else {echo"<script>alert('file size is too big!')
          window.location.href = '/www/home.php'</script>";
        }

     }else {echo"<script>alert('there was an error while uploading your file')
      window.location.href = '/www/home.php'</script>";};

    }else {echo"<script>alert('file extetion is not accepted')
      window.location.href = '/www/home.php'</script>";
     };
   
}else{echo"<script>alert('you have not speciified a picture')
  window.location.href = '/www/home.php'</script>";};

?>