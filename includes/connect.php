
<?php
/* this file has the database connection and all the funtions to request or add data to the database,I included it in
the header so I can have access to the funtions in all the websites pages */

//this variable holds the database connection
$conn = new mysqli('eu-cdbr-west-03.cleardb.net', 'b23ec349649b7f', '28a349b2', 'heroku_55fb14b2a0d4dc2');



/* handles the new users registration request */
function registration($conn, $usern, $pass, $emai, $dob, $gen, $id, $first_name, $family_name, $country, $status, $posts, $p_pic, $desc_user, $relationship, $c_pic, $recov){

  $sql = "INSERT into users(user_id,f_name,l_name,user_name,user_pass,user_email,user_country,user_gender,user_birthday,status,posts,user_image,describe_user,relationship,user_cover,recovery_account) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
  $sql2 = "SELECT * from users  where user_name='" . $usern . "'";
  $chk = $conn->query($sql2);
  if ($chk->num_rows > 0) {
        echo 'user already exists';} 
  else {
    $sql3 = "SELECT * from users  where user_email='" . $emai . "'";
    $chk = $conn->query($sql3);
    if ($chk->num_rows > 0) {
      echo 'email already been used';
    } else {

      $results = $conn->query($sql);
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssssssssssss", $id, $first_name, $family_name, $usern, $pass, $emai, $country, $gen, $dob, $status, $posts, $p_pic, $desc_user, $relationship, $c_pic, $recov);
      $stmt->execute();
      $conn->close();
      echo "<script>alert('You have been registred $first_name,welcome to my website'  )</script>";
    };
    echo "<script>window.open('index.php','_self' )</script>";
  };
};



//handles a login request
function loginRequest($conn, $usern, $pass)
{

  $sql = "SELECT * from users  where user_name='" . $usern . "' and user_pass = '" . $pass . "'";
  $results = $conn->query($sql);
  if (!$results) {
    header('location:/wrong_inf.php');
  }

  if ($results->num_rows > 0) {
    session_start();
    $_SESSION['user'] = "$usern";

    echo "<script>window.open('home.php','_self' )</script>";
  } else {
    header('location:/wrong_inf.php');
  };
};

//logs out the user



function disconnect($conn)
{
  $sql = "UPDATE users SET isonline= '0' where user_name='" . $_SESSION['user'] . "';";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  session_destroy();
};



//puts the user in an online status
function online($conn)
{
  $sql = "UPDATE users SET isonline= '1' where user_name='" . $_SESSION['user'] . "';";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
};





//handles message sending
function messageSending($conn, $to, $message, $id)
{
  $sql = "SELECT * from users  where user_name='" . $to . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('cant send Your message right now');
  }
  if ($results->num_rows == 0) {
    echo 'this user does not exist!';
  };
  if ($results->num_rows > 0) {
    $sql2 = "INSERT into messages(id,sender,reciever,message) values(?,?,?,?);";

    $results2 = $conn->query($sql2);
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("ssss", $id, $_SESSION['user'], $to, $message);
    $stmt->execute();
    header('location:/messages/message_sent.php');
    $conn->close();
  };
};




//finds all the messages you have sent or been sent to you
function myMessages($conn)
{
  //finds all messages related to you                                 
  $users_messaged = "SELECT * from messages where sender='" . $_SESSION['user'] . "' or reciever='" . $_SESSION['user'] . "' ";
  $users_m = $conn->query($users_messaged);
  if (!$users_m) {
    throw new Exception("You haven't messaged anyone yet.");
  } else

    $array = [];
  while ($row = $users_m->fetch_assoc()) {
    //finds all the people you have messaged or messaged you and pushes them into an array
    if ($row['sender'] == $_SESSION['user']) {
      array_push($array, $row['reciever']);
    } else if ($row['reciever'] == $_SESSION['user']) {
      array_push($array, $row['sender']);
    };
  }
  //make the people you messaged or messaged you unique so you dont have them twise..
  $array = array_unique($array);
  //make the values keys 0.1.2....
  $new_array = array_values($array);
  //chek if you have no messages nor messaged anyone
  if ($new_array == []) {
    echo "<p id='no_messages' class='alert alert-danger'>You have not messaged anyone yet!</p>";
    echo "<div class='row'>";
    echo "<div id='users_messaged' class='overflow-auto col-2'>";
  }
  //if you have messages:
  else {
    echo "<div class='row'>";
    echo "<div id='users_messaged' class='overflow-auto col-2'>";
    for ($x = 0; $x <= (sizeof($new_array) - 1); $x++) {
      //use of jquerry so when you click the template it doesnt need to refresh the page
      echo ' <script>
$(document).ready(function(){$("#' . $new_array[$x] . '").click(function(e){
 e.preventDefault(); $("#contentDiv").load("/messages/user_messages.php?message=' . $new_array[$x] . '")})});
</script>';
      echo "<div id=template>";
      echo "<li>";
      //shows the messaged user template that when you click on it it loads the user messages
      user_pic($conn, $new_array[$x]);
      echo "<a id='$new_array[$x]' href=''>";
      echo $new_array[$x] . "</a>";
      echo "</li>";
      echo "</div>";
    }

    echo "</div>";;
  }
}



//this funtion shows your conversation with a user after you click on their template
function user_messages($userm, $conn)
{

  myMessages($conn, $userm);
  $sql = "SELECT * from messages  where sender='" . $_SESSION['user'] . "' or reciever='" . $_SESSION['user'] . "' ";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('there is no result.');
  }
  if ($results->num_rows > 0) {

    echo "<div  class='col-9 ps-0'>";
    echo '<div id="the_messages" class="overflow-auto">';
    while ($row = $results->fetch_assoc()) {
      if (($row["sender"] == $_SESSION['user'] && $row["reciever"] == $userm) || ($row["reciever"] == $_SESSION['user'] && $row["sender"] == $userm)) {
        if ($row["sender"] == $_SESSION['user']) {
          echo "<p class='alert alert-dark col-4' id='sender'> " . $row["message"] . " <br> <p id='at_s'> at   " . $row["timestamp"] . " </p></p>";
        };
        if ($row["reciever"] == $_SESSION['user']) {
          echo "<p class='alert alert-success col-5' id='reciever'> " . $row["message"] . " <br>  at <p id='at'>  " . $row["timestamp"] . "</p></p>";
        }
      };
    }
    $otheruser = $_GET['message'];
    echo "</div>";
    echo '
         <form action="message_sending.php" method="post">                                     
         <input type="hidden" name="to" value=' . $otheruser . ' size="15"
          maxlength="20" />
          <div class=row id="new_msg">
          <div class="col-11 pe-0">
          <input type="text" class="form-control " id="new_message" name="the_message" placeholder="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp type your message here" size="100"
            maxlength="200" />
           </div>
            <div class="col-1 ps-0">
            <input class="btn btn-secondary" id="send_btn" type="submit" value="send" />
           </div></div>                                                  
           </form>    ';
  };
  echo "</div>";
  echo "</div>";
};




//find a person using the search bar
function findPeople($user, $conn)
{

  $sql = "SELECT * from users  where user_name LIKE  '%$user%'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('there is no result.');
  }
  echo 'You have ';
  echo $results->num_rows;
  echo ' result(s)';
  if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
      echo "<br>";
      user_template($conn, $row["user_name"]);
      echo "<br>  <a href='/friends/send_friend_request.php?user=" . $row["user_name"] . " '><button class='btn btn-primary'>send a friend request</button><br></a>   ";
    }
  };
};



//finds all the notes that you wrote and shows them
function findNotes($conn)
{
  $sql = "SELECT * from notes  where user_name='" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('You have no notes.');
  }
  echo '<p id="num_notes" class="alert alert-dark">You have ';
  echo $results->num_rows;
  echo ' note(s) :<p><br>';
  if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
      echo "<br><p class='alert alert-warning'> " . $row["note"] . " </p>";
    }
  };
};



//inserting the new note into the database after pressing create note
function newNotes($conn, $note, $user)
{
  $sql = "INSERT into notes(note,user_name) values(?,?);";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $note, $user);
  $stmt->execute();
  $conn->close();
  echo ' <script>
       $(document).ready(function(){$("#add_note_btn").click(function(e){
       e.preventDefault(); $("#contentDiv").load("/notes/note_created.php")});});
        </script>';
};



//shows templates of people who are registred to the website
function findAllPeople($conn)
{
  $sql = "SELECT * from users  where user_name<>'" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('there is no result.');
  }
  echo "<div id='main_container'>";
  echo '<div id="contentDiv"><div id="results_num"> You have ';
  echo $results->num_rows;
  echo ' result(s)</div><div id="people_grid">';
  if ($results->num_rows > 0) {

    echo '<div class="container">';

    $i = 6;
    while ($row = $results->fetch_assoc()) {

      if ($i == 6) {
        echo ' <div class="row">';
        $i = 0;
      }
      $i = $i + 1;
      echo '<div class="col-2">';
      echo "<div class='user_temp'>";
      user_template($conn, $row["user_name"]);
      echo "</div>";
      if ($i == 6) {
        echo "</div>";
      };
      echo "</div>";
    };
  };
};




//finds and shows the result of people those details corresponds to
function adv_people_search($conn, $sql)
{
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('there is no result.');
  }
  echo '<div id=main_container>';
  echo '<div id="contentDiv"> <div id="num_results"> You have ';
  echo $results->num_rows;
  echo ' result(s)</div>';
  if ($results->num_rows > 0) {
    echo '<div class="container">';

    $i = 6;
    while ($row = $results->fetch_assoc()) {
      if ($i == 6) {
        echo ' <div class="row">';
        $i = 0;
      }
      $i = $i + 1;
      echo '<div class="col-2">';
      echo "<div class='user_temp'>";
      user_template($conn, $row['user_name']);
      echo "</div>";
      if ($i == 6) {
        echo "</div>";
      };
      echo "</div>";
    };
  }
  echo "</div>";
}




//showing a users profile after you click on a persons template
function veiwProfile($conn, $userp)
{
  $sql = "SELECT * from users where user_name='" . $userp . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('there was a problem,you cant see this profile :( .');
  } else  if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {

      echo "<h1> $userp Profile</h1> " .
        user_pic($conn, $userp) .
        '<br>',
      '<username: ' . $row["user_name"] . '<br>',
      'country: ' . $row["user_country"], '<br>',
      'gender: ' . $row["user_gender"], '<br>',
      'registration date: ' . explode(" ", $row["user_reg_date"])[0], '<br>',
      'age: ' . $row["user_age"], '<br>',
      'date of birth: ' . $row["user_birthday"], '<br>';
      friend_status($conn, $_SESSION['user'], $userp);
      echo '
         <form action="messages/message_sending.php" method="post">
         <input type="hidden" name="to" value=' . $userp . ' size="15"
         maxlength="20" />
         <div class=row id="new_msg">
          <div class="col-7 pe-0">
        <input type="text" class="form-control " id="new_message" name="the_message" placeholder="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp type your message here" size="100"
        maxlength="200" />
         </div>
          <div class="col-1 ps-0">
          <input class="btn btn-success" id="send_btn" type="submit" value="send" />
          </div></div>
                           
          </form>  ';
    }
  };
};



//calculates the age of  a user using his date of birth
function age_calculator($user_birthday)
{
  $date_ob = $user_birthday;
  if (!isset($date_ob)) {
    echo 'AN error has occured';
  };

  list($year, $month, $day) = explode("-", $date_ob);
  if ($day == null || $month == null || $year == null) {
    echo "<p>your profile is missing information regarding your date of birth</p>";
  } else if ($day == 0 || $month == 0 || $year == 0) {
    echo "<h1>the value of the fields can't be 0 or a string </h1>";
  } else {



    $bdayunix = mktime(0, 0, 0, $month, $day, $year); // get ts for then
    $nowunix = time(); // get unix ts for today
    $ageunix = $nowunix - $bdayunix; // work out the difference
    $age = floor($ageunix / (365 * 24 * 60 * 60)); // convert from seconds to years
    $agemin = floor($ageunix / 60);
    $agehours = floor($agemin / 60);
    $agedays = floor($agehours / 24);
    $ageweeks = floor($agedays / 7);
    $agemonths = floor($agedays / 30);

    //$ageunix=floor($ageunix/(3600*24*365));
    echo "<h1>You have lived for:</h1>
<ul>
<br>
<li>$ageunix seconds
<li>$agemin minutes
<li>$agehours hours
<li>$agedays days
<li>$ageweeks weeks
<li>$agemonths months
<li>$age years
</ul>
";
    return $age;
  }
}




//finds someones age using his date of birth
function age_years($user_birthday)
{
  $date_ob = $user_birthday;
  if (!isset($date_ob)) {
    echo 'AN error has occured';
  };

  list($year, $month, $day) = explode("-", $date_ob);
  if ($day == null || $month == null || $year == null) {
    echo "<p>your profile is missing information regarding your date of birth</p>";
  } else if ($day == 0 || $month == 0 || $year == 0) {
    echo "<h1>the value of the fields can't be 0 or a string </h1>";
  } else {



    $bdayunix = mktime(0, 0, 0, $month, $day, $year); // get ts for then
    $nowunix = time(); // get unix ts for today
    $ageunix = $nowunix - $bdayunix; // work out the difference
    $age = floor($ageunix / (365 * 24 * 60 * 60)); // convert from seconds to years
    $agemin = floor($ageunix / 60);
    $agehours = floor($agemin / 60);
    $agedays = floor($agehours / 24);
    $ageweeks = floor($agedays / 7);
    $agemonths = floor($agedays / 30);

    return $age;
  }
}



//inserting the users age in the database
function insert_age($conn, $age)
{
  $sql = "UPDATE `heroku_55fb14b2a0d4dc2`.`users` SET `user_age` = '" . $age . "' WHERE (`user_name` ='" . $_SESSION['user'] . "' ) ;";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $conn->close();
};



//finds all people who send you a friend request
function friend_requested($conn)
{
  $sql = "SELECT * from friends_table  where accepted =0 and user_to='" . $_SESSION['user'] . "' ";
  $results = $conn->query($sql);
  echo '<div> You have ';
  echo $results->num_rows;
  echo ' friend requests</div>';
  $i = 6;
  while ($row = $results->fetch_assoc()) {

    if ($i == 6) {
      echo ' <div class="row">';
      $i = 0;
    }
    $i = $i + 1;
    echo '<div class="col-2">';
    echo "<div class='user_temp'>";
    user_template($conn, $row['user_from']);
    echo "</div>";
    if ($i == 6) {
      echo "</div>";
    };
    echo "</div>";
  };
}



//finds all people in your friend list
function friend_list($conn)
{
  $sql = "SELECT * from friends_table  where accepted =1 and (user_from='" . $_SESSION['user'] . "' or user_to='" . $_SESSION['user'] . "')";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('There is no one in your friends list.');
  }
  echo '<div id="friends_num"> You have ';
  echo $results->num_rows;
  echo ' friends(s)</div>';
  if ($results->num_rows > 0) {
    echo '<div class="container">';

    $i = 6;
    while ($row = $results->fetch_assoc()) {
      if ($i == 6) {
        echo ' <div class="row">';
        $i = 0;
      }
      $i = $i + 1;
      echo '<div class="col-2">';
      echo "<div class='user_temp'>";
      if ($row["user_from"] == $_SESSION['user']) {


        user_template($conn, $row["user_to"]);
      } else {

        user_template($conn, $row["user_from"]);
      }
      echo "</div>";
      if ($i == 6) {
        echo "</div>";
      };
      echo "</div>";
    };
  };
};


//send a friend request to someone
function send_friend_request($conn, $user)
{
  $sql = "INSERT into friends_table(user_from,user_to) values('" . $_SESSION['user'] . "','" . $user . "')";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('could not send a friend request.');
  } else {
    header('location:/friends/friend_request_sent.php');
  };
};



//accept a friend request
function accept_friend_request($conn, $user)
{
  $sql = "UPDATE `heroku_55fb14b2a0d4dc2`.`friends_table` SET `accepted` = 1 WHERE user_from='" . $user . "' and user_to='" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('could not accept the friend request.');
  } else {
    header('location:/friends/friend_request_accepted.php');
  };
}
/*  shows in other users profile the status of your friendship:
(already friends,not friends,fried request sent or he sent you a friend request...)*/



function friend_status($conn, $user, $other)
{
  $sql = "SELECT * from friends_table  where user_from='" . $_SESSION['user'] . "' or user_to='" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);
  $x = 0;
  while (($row = $results->fetch_assoc()) && $x < 1) {

    if (($row["user_from"] == $_SESSION['user'] && $row["user_to"] == $other && $row["accepted"] == 1) || ($row["user_to"] == $_SESSION['user'] && $row["user_from"] == $other && $row["accepted"] == 1)) {
      echo "<p class='alert alert-secondary col-3' id='friend_status'>You are friends</p>";
      $x = 1;
    } else if ($row["user_from"] == $_SESSION['user'] && $row["user_to"] == $other && $row["accepted"] == 0) {
      echo "<p class='alert alert-secondary col-3' id='friend_status'>a friend request has already been sent";
      $x = 1;
    } else if ($row["user_to"] == $_SESSION['user'] && $row["user_from"] == $other && $row["accepted"] == 0) {
      echo "<a href='/friends/accept_friend_request.php?user=$other' class='btn btn-success'>accept his/her friend request</a>";
      $x = 1;
    }
  }
  if ($x == 0) {
    echo "<a href='/friends/send_friend_request.php?user=$other' class='btn btn-secondary '>send a friend request</a>";
  };
};




//generates a small picture for your profile
function profile_pic($conn)
{

  $sql = "SELECT * from users  where user_name='" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);

  if (!$results) {
    throw new Exception('couldnt load your profile pic.');
  } else {
    while ($row = $results->fetch_assoc()) {
      $userpic = $row['user_image'];
      echo "<img src=/images/uploads/" . $userpic . " id='p_photo' class=rounded-circle alt=" . "profile pic" . " width='60' height='60' />";
    }
  };
};



//finds your profile picture
function find_profile_pic($conn)
{

  $sql = "SELECT * from users  where user_name='" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);

  if (!$results) {
    throw new Exception('couldnt load your profile pic.');
  } else {
    while ($row = $results->fetch_assoc()) {
      return ($row['user_image']);
    }
  };
};



//generates other peoples user pictures
function user_pic($conn, $user)
{
  $sql = "SELECT * from users  where user_name='" . $user . "'";
  $results = $conn->query($sql);
  while ($row = $results->fetch_assoc()) {
    $userpic = $row['user_image'];

    echo "<img src=" . "/images/uploads/" . $userpic . " alt=" . "picture" . " width='100' height='100'/> ";
  }
};



//update your profile picture
function update_profile_pic($file_new_name, $conn)
{

  $sql = "UPDATE `heroku_55fb14b2a0d4dc2`.`users` SET `user_image` = '" . $file_new_name . "' where user_name='" . $_SESSION['user'] . "' ";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('could not update your profile picture.');
  } else {
    echo "<script>alert('Your profile picture has been updated!'); history.back()</script>";;
  }
};



//upload a photo to my photos
function upload_photo($file_new_name, $conn)
{
  $sql = "INSERT into photos(user_name,photos) values (?,?) ;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $_SESSION['user'], $file_new_name);
  $stmt->execute();
  echo "<script>alert('your picture has been uploaded!');window.history.go(-2);</script>";
  $conn->close();
};



//shows all your photos
function myPhotos($conn)
{
  $sql = "SELECT * from photos  where user_name='" . $_SESSION['user'] . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('you have no photos.');
  }
  echo 'You have ';
  echo $results->num_rows;
  echo ' photos : <br>';
  if ($results->num_rows > 0) {



    $i = 6;
    while ($row = $results->fetch_assoc()) {
      if ($i == 6) {
        echo ' <div class="row">';
        $i = 0;
      }
      $i = $i + 1;
      echo '<div class="col-2">';
      $img_name = explode('.', $row["photos"])[0];

      echo "<div class='photos'>";
      echo ' <script>
            $(document).ready(function(){$("#' . $img_name . '").click(function(e){
             e.preventDefault(); $("#contentDiv").load("/images/photo_preview.php?image_id=' . $row["photos"] . '")})});
                </script>';

      echo "<a id=" . $img_name . " href=''" . "><img src=" . "/images/uploads/" . $row['photos'] . " alt=" . "picture" . " width='100' height='100'/></a>";
      if ($i == 6) {
        echo "</div>";
      }
      echo "</div>";
      echo "</div>";
    }
  };
}



// shows the full size of a photo after you chose one
function preview_photo($conn, $image_id)
{

  $sql = "SELECT * from photos  where photos='" . $image_id . "'";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('You cant see this photo.');
  } else {
    echo "<img src=" . "/images/uploads/" . $image_id . " alt=" . "picture" . " id='image_preview' width='500' height='500'/>";;
  }
}



//generates a user template
function user_template($conn, $user)
{
  $sql = "SELECT * from users  where user_name='" . $user . "'";
  $results = $conn->query($sql);
  while ($row = $results->fetch_assoc()) {
    echo "<div id='profile_pic'>";
    echo "<img src=/images/uploads/" . $row['user_image'] . " id=pic alt=" . "picture" . " width='100' height='100'/>";
    echo "</div>";
    echo "<div id='user_inf' >";
    echo  "<a " . 'href="/profiles.php?user=' . $row['user_name'] . '"' . "id=user_name>" . $row['user_name'] . "</a>,&nbsp" . $row['user_age'] . " ";
    echo "</div>";;
  };
}



//upload a post
function upload_post($file_new_name, $conn, $text)
{
  $sql = "INSERT into posts(user_name,post_text,post_image) values (?,?,?) ;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $_SESSION['user'], $text, $file_new_name);
  $stmt->execute();
  echo "<script>alert('Your post has been uploaded!');window.location.replace('/posts/view_my_posts.php');</script>";
  $conn->close();
}



//veiw all posts your friends have shared
function veiw_posts($conn)
{
  $sql = "SELECT * from friends_table  where accepted =1 and (user_from='" . $_SESSION['user'] . "' or user_to='" . $_SESSION['user'] . "')";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('there is no one in your friends list.');
  }
  if ($results->num_rows > 0) {
    $friendlist = [];
    while ($row = $results->fetch_assoc()) {
      if ($row["user_from"] == $_SESSION['user']) {
        array_push($friendlist, $row["user_to"]);
      } else {
        array_push($friendlist, $row["user_from"]);
      };
    };
  }
  $sql2 = "SELECT * from posts ";
  $results2 = $conn->query($sql2);
  if (!$results2) {
    throw new Exception('there are no posts to see.');
  };
  if ($results2->num_rows > 0) {
    if (!isset($friendlist)) {
      echo "there are no posts to be seen";
    } else {
      while ($row = $results2->fetch_assoc()) {

        if (in_array($row["user_name"], $friendlist)) {
          post($conn, $row['idposts']);
        };
      }
    }
  }
};




//veiw all the post that you have shared
function veiw_my_posts($conn)
{
  $sql = "SELECT * from posts where user_name='" . $_SESSION['user'] . "' ";
  $results = $conn->query($sql);
  if (!$results) {
    echo 'there are no posts to see.';
  } else {
    while ($row = $results->fetch_assoc()) {
      post($conn, $row['idposts']);
    }
  };
};



// generates a single post
function post($conn, $id)
{
  $sql = "SELECT * from posts where idposts=$id";
  $results = $conn->query($sql);
  if (!$results) {
    throw new Exception('this post does not exist');
  };
  if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
      $post_text = $row["post_text"];
      $post_username = $row["user_name"];
      $post_image = $row["post_image"];
      $post_likes = $row["likes"];
    }
    echo "<div id=post>";
    echo "<div id=the_post class='row'>";
    echo "<div id=user_template_post class='col-md-2'>";
    user_template($conn, $post_username);
    echo "</div>";
    echo "<div id='post_text' class='col-md-8 px-4' >";
    echo $post_text;
    echo "</div>";
    echo "</div>";
    //checks if the the post have an image
    if($post_image<>null){
    echo "<div id='post_image'>";
    echo "<img src=" . "/posts/uploads/" . $post_image . " alt=" . "picture" . " width='500' height='500'/>";
    echo "</div>";};
    //shows a like button and the number of likes
    echo '<form action="/posts/like.php" method="post" enctype="multipart/form-data">
    <input type="hidden" id="id" name="post_id" value="' . $id . '">
    <button type="submit" id="like_button" name="like" class="btn" ><img src="/default_p_pic/like.png"  width="40" height="40"></button>' . $post_likes . '
    </form>';

    echo '<script>
    $(document).ready(function(){$("#comment_' . $id . '").click(function(e){
      e.preventDefault(); $("#contentDiv").load("/posts/make_comment.php")})});
     </script>';

    echo '<form id="comment_form" method="post" action="/posts/make_comment.php">
     <div class="tooltip-bg" id="comment">
      <div class="tip"></div> 
    <input type="text" placeholder="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp comment here" id="speech-input"  name="comment"  size="100"></div>
     <input  type="hidden" id="id"  name="post_id" value="' . $id . '">
     <input type="submit" class="btn btn-primary" id="submit" value="submit " >
   </form>';
    veiw_coments($conn, $id);
    echo "</div>";
  }
}
//handles add comment



function add_comment($conn, $id, $comment)
{
  $sql2 = "INSERT into posts_comments(id,comments,user_name) values(?,?,?);";

  $results2 = $conn->query($sql2);
  $stmt = $conn->prepare($sql2);
  $stmt->bind_param("sss", $id, $comment, $_SESSION['user']);
  $stmt->execute();
  echo '<script>alert("Your comment has been added")';
  $conn->close();;
}
//shows all the comments



function veiw_coments($conn, $id)
{
  $sql = "SELECT * from posts_comments where id=$id";
  $results = $conn->query($sql);
  if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
      echo "<div id='u_comment'> <p id='u_n' ' role='alert'>$row[user_name] </p><div id='a_comment' class='alert alert-primary'> $row[comments] </div></div>";
    }
  }
}



//handdles when you click on like button
function like($conn, $id)
{

  $sql = "UPDATE posts SET likes = likes + 1 WHERE idposts=$id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  echo "done";
}
?>
