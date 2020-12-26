<?php 
session_start();
if (!isset($_SESSION['user'])){header('location:/www/index.php');}else{


include "connect.php";
online($conn);
			$user = $_SESSION['user'];
			$get_user = "select * from users where user_name='$user'"; 
			$run_user = mysqli_query($conn,$get_user);
			$row=mysqli_fetch_array($run_user);		
			$user_id = $row['user_id']; 
			$user_name = $row['user_name'];
			$first_name = $row['f_name'];
			$last_name = $row['l_name'];
			$describe_user = $row['describe_user'];
			$Relationship_status = $row['Relationship'];
			$user_pass = $row['user_pass'];
			$user_email = $row['user_email'];
			$user_country = $row['user_country'];
			$user_gender = $row['user_gender'];
			$user_birthday = $row['user_birthday'];
			$user_image = $row['user_image'];
			$user_cover = $row['user_cover'];
			$recovery_account = $row['recovery_account'];
			$register_date = $row['user_reg_date'];
			$age=age_years($user_birthday);
			$female_image='<img src="../default_p_pic/female.png" alt="female" />';
			$male_image='<img src="../default_p_pic/male.png" alt="male" />';
		}
			?>
