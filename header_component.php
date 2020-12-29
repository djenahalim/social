
<header>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<link href="/css/style.css" rel="stylesheet"> 
<link href="/css/bootstrap.min.css" rel="stylesheet"> 
<script src="/js/bootstrap.min.js"> </script>
<!-- search for people -->
<script type="text/javascript">
      $(function() {
        $("#lets_search").bind('submit',function() {
          var value = $('#str').val();
           $.post('/people/find_user.php',{value:value}, function(data){
             $("#contentDiv").html(data);
           });
           return false;
        });
      });
    </script>

</header>

<div id=header_component class="container-fluid sticky-top ">

  <div id="header_row" class="row  pb-1">
    
    <div class="col-md-1  ">
        <?php
            echo"<img src=/default_p_pic/logo.png id='logo' alt="."logo"." width='50' height='50' />";?>
        </div>
    <div class="col-md-4 ps-1 ">
          <div class="container-fluid">
           
          <form id="lets_search" action="" class="d-flex " >
          <div class="col-xs-2">
            <input class="form-control" type="search" placeholder="Find a friend..." name="str"  id="str" aria-label="Search" >
           </div> 
            <button class="btn btn-outline-secondary" type="submit" name="send" id="send">Search</button>
             </form>
            </div>
          </div>
     <div class="col-md-2 ">
          <nav id ="icon_navbar" class="navbar navbar-expand-lg navbar-light  pb-0 pt-0" >
  <div class="container-fluid">
    
      <ul class="navbar-nav">
        

        <li class="nav-item">
        <a class="nav-link" href="\home.php"><img src="/default_p_pic/home.svg" alt= home width='32' height='32'></a> 
        </li>
        
        <li class="nav-item">
        <a class="nav-link" href=\messages\messages.php><img src="/default_p_pic/message.svg" width='32' height='32' alt= Messages></a> 
        </li>
       
        <li class="nav-item">
        <a class="nav-link" id="view_friends" href=""><img src="/default_p_pic/people.svg" width='32' height='32' alt= friendlist> </a> 
        </li>
        
      </ul>
    </div>
</nav> </div>
      <div id="profile_temp" class="col-md-2 " >
      
      
    
      
          <?php echo
             profile_pic($conn);
              ?>
         
       <?php    
       echo $user_name;?>
          </div>
 <div class="col-md-2">
<a class="btn btn-danger mt-2 " id="logout" href="/logout.php">log out</a>

 </div>

      


    
        </div>
        
        <hr id="hrow">
   </div>
 
</div>