<?php

include "includes/header.php";
echo"<div class='container ' >
     <div class='row '>
         <div class='col-8'>";

$image_id=find_profile_pic($conn);
preview_photo($conn,$image_id);
echo'<div  id="change">
<button type="button" class="btn btn-danger btn-sm "  id="change_image" href="" >change profile picture</button>
</div>';
echo"</div>";
echo"<div class='col-4'>";
echo '
<div class="alert alert-light py-2" role="alert">
User name: '.$user.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
Birthday: '.$user_birthday.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
First name: '.$first_name.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
Last name: '.$last_name.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
Email: '.$user_email.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
Country: '.$user_country.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
Gender: '.$user_gender.'<br>','
</div>
',
'
<div class="alert alert-light  py-2" role="alert">
Registration date: '.explode(" ",$register_date)[0].'<br>','
</div>
',
'
<div id="profile_inf" class="alert alert-light  py-2" role="alert">
Age: '.$age.'<br>','
</div>
';
echo"</div>";echo"</div>";


?> 

<script>
$(document).ready(function(){$("#change_image").click(function(e){
  e.preventDefault(); $("#contentDiv").load("/www/images/images.php")});});
 </script>