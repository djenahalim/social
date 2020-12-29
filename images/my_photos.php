<?php
include "../includes/header.php";

myPhotos($conn);

?>
 



<form action="/www/images/photos_upload.php" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-5">

<input class="form-control form-control-lg" type="file" name="file" id="file">
</div>
<div class="col-5">
<button type="submit" class="btn btn-lg btn-success" name="submitp" id="submitp">upload image</button>
</div>
</form>
</div>
<!-- <div id="contentDiv2"></div> -->