

 <?php  echo'
 
<nav class="navbar navbar-expand-lg navbar-light bg-light">
 
 <ul id="nav_link" class="navbar-nav  ">
       

        <li class="nav-item">
          <a class="nav-link ms-4" id="posts" href="\posts\my_posts.php">My friends posts</a> 
        </li>

        <li class="nav-item">
        <a class="nav-link ms-4" id="my_posts" href="\posts\view_my_posts.php">My posts</a> 
      </li>

        <li class="nav-item">
          <a class="nav-link" id="view_notes" href="">Notes</a> 
        </li>
        
        <li class="nav-item">
          <a class="nav-link" id="find_friends" href=\people\search_people.php>Find New Friends</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link" id="view_profile" href="">Profile</a> 
          </li>
        
        </li>
        <li class="nav-item">
          <a class="nav-link" id="my_photos" href="">Photos</a> 
        </li>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="age_calculator" href="">Age Calculator</a> 
        </li>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="fancy-line"></div>
'

;?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- veiw  profile-->
<script>
$(document).ready(function(){$("#view_profile").click(function(e){
  e.preventDefault(); $("#contentDiv").load("/myprofile.php")});});
 </script>
 <!-- notes -->
 <script>
$(document).ready(function(){$("#view_notes").click(function(e){
  e.preventDefault(); $("#contentDiv").load("/notes/notes_finder.php")});});
 </script>
<!-- photos -->
<script>
$(document).ready(function(){$("#my_photos").click(function(e){
  e.preventDefault(); $("#contentDiv").load("/images/my_photos.php")});});
 </script>

<!-- friend list -->
<script>
$(document).ready(function(){$("#view_friends").click(function(e){
  e.preventDefault(); $("#contentDiv").load("/friends/friendlist.php")});});
 </script>

    <!-- age calculator -->
    <script>
$(document).ready(function(){$("#age_calculator").click(function(e){
  e.preventDefault(); $("#contentDiv").load("/age_calculator/age_calculator.php")});});
 </script>
  <!-- images -->
 

      <style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}


</style>
