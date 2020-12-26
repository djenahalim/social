<?php 
include "../includes/header.php";
include "../header_component.php";
include "../nav_link.php";
if(!isset($_POST['send'])){
    header('Location: /www/people/search_people.php');
}
else{
$age=$_POST['age'];
$gender=$_POST['gender'];
$country=$_POST['country'];
$isonline=isset($_POST['isonline']);
$photo=isset($_POST['photo']);
$con1='"';$con2='"';$country=$con1.$country.$con2;
if ($country=='"Any Country"'){$country="";}else {$country="and user_country= ".$country;};
if ($isonline==1){$isonline="and isonline= 1";} else{$isonline="";};

switch ($age) {
    case 0:
        $age="user_age<20";
        break;
    case 1:
        $age= "user_age>=20 and user_age<30";
        break;
    case 2:
        $age= "user_age>=30 and user_age<40";
        break;
    case 3:
        $age= "user_age>=40";
            break;
}
if ($photo==1){$photo="and user_image<>'female.png' and user_image<>'male.png' ";} else {$photo="";};
$sql="select * FROM users WHERE  $age and user_name<>'".$_SESSION['user']."' and user_gender='$gender'  $country $isonline $photo";

adv_people_search($conn,$sql);

echo"</div>";}

?>