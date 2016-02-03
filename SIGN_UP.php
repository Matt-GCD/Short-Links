<?php
	//picture array
	$pics = array('images/blue.png', 'images/pink.png', 'images/green.png', 'images/purple.png' );
	//random number based on the array size
	$i = rand(0, count($pics)-1);
	//selects random picture based on the number
	$pic = "$pics[$i]";
?>
<!DOCTYPE html>

<!--html page mark up-->
<html lang="en">
	
<head><!--mark up for page header-->
	<meta charset="utf-8"><!--sets page format-->
	<title>Shortlink.com Sign-up</title><!--page name-->
	<meta content="Shortlinks.com" name="description">
	<meta content="FRW" name="author"><!--Author name -->
	<link href="style.css" rel="stylesheet"><!--Link to CSS style sheet -->
	<link href="images/icon.png" rel="icon" sizes="16x16" type="image/png"><!--Link to image to appear in tab on browser -->
	<style type="text/css">
			<!--
			body{
			background: url(<?php echo $pic; ?>) repeat;
			}
			-->
	</style>
</head><!--denotes end of head markup-->

<body onload="startTimer()">	
	<img id="img" background="images/green.png">
	<div id="container" align="center">
			
		<div id="banner">
		<!--Banner image for Shortlink.com & link login page-->
		<a href="FRW_LOGIN.php">
		<img  align="center" alt="banner" class="center" src="images/banner.png" />
		</a>
		</div>
			
		<!--Sign in form for new users-->
		<div id="sign-up" align="center"> 
			<form  action="SIGN_UP.php" method="post">
				<!--Username entry field-->
				<input type="text" placeholder="User name " name="username" size="50" required="required" id= "Username"/>
				<!--Password entry field-->
				<input type="password" placeholder="Password " name="password" size="50" required="required" id= "Password"/>
				<!--Re-enter Password entry field-->
				<input type="password" placeholder="Re-enter password " name="passwordcheck" size="50" required="required" id= "Re-enter_password" /> 
				<!--Email entry field-->
				<input type="text" placeholder="Email " name="email" size="50" required="required" id= "Email"/>
				<!--First name entry field-->
				<input type="text" placeholder="First name " name="fname" size="50" required="required" id= "First_name"/>
				<!--Surname entry field-->
				<input type="text" placeholder="Surname " name="sname" size="50" required="required" id= "Surname"/>
				<!--Submit button-->
				<button type="submit" value="submit" id= "sign_up_button" class="sign_up_button" style="border: 0; background: transparent">
				<!--Link to sign in image-->
				<img width= "100%" height="100%" alt="submit" src="images/sign_up_button.png" />
				</button>
			</form>
		</div><!--End of form-->
			
		<div id="make_your_links_managable"><!--Tag line for website with image -->
		<img  align="center" alt="banner" class="center" src="images/make_your_links_managable.png" />
		</div>
			
	
	</div><!--End of main contaner-->
	
	<!--Footer-->
	<div id="footer" align="center"> <!--Link to About page in footer -->
		<!-- About page image & link to about page-->
		<a href="about.php" id= "about">
		<img src="images/about.png" alt="about" id= "about">
		</a>
	</div><!--End of Footer-->

</body><!--denotes end of body markup-->
</html><!--denotes end of html markup-->

<?php
//PHP MARK-UP
		//Linking SQL server & Connection to the Database
				//database variables	
					$host = 'gcdsrv.com';
					$user = 'frw';
					$pswd = 'tefalu76';
					$dbSQL = 'frw_short_links';
					
				//Linking SQL server & Connection to the Database
					$con = mysql_connect($host, $user, $pswd);
						if (!$con){
							die("Could not connect: " . mysql_error());
						}
						
				//connects database
					mysql_select_db($dbSQL);	
//SQL
	//if requests are send by post method, complete these.
	if($_SERVER["REQUEST_METHOD"] === "POST"){
			//USER DETAILS
				$username = ($_POST['username']);
				$password = ($_POST['password']);
				$password_check = ($_POST['passwordcheck']);
				$email = ($_POST['email']);
				$fname = ($_POST['fname']);
				$sname = ($_POST['sname']);
					
			//regular expressions, check variables for correct naming format
				$emailRegex = "/^[a-z\d\._-]+@([a-z\d-]+\.)+[a-z]{2,6}$/i";
				$nameRegex = "/^[A-Z][a-z]{3,60}$/";
										
	//function to validate names and email				
				//email check.
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					//password check.
					if($password === $password_check){				
						//checks if exists, if no, creates new account.
					$query_pass = "SELECT * FROM USERS WHERE USER_ID = '$username' AND PASSWORD = '$password'";
					$result_pass = mysql_query($query_pass) or die('Error');
					$count_pass = mysql_num_rows($result_pass);
						
						if($count_pass == 0){
							//creates account
							mysql_query("INSERT INTO USERS (USER_ID, PASSWORD, STATUS) VALUES('$username', '$password', 'Basic')");
							mysql_query("INSERT INTO DETAILS (F_NAME, S_NAME, USER_EMAIL, USER) VALUES('$fname', '$sname', '$email', '$username')");
								//if email is set, complete
								if(isset($_POST['email'])){
									//Email information
									ini_set('auth_username', 'admin@frw.gcdsrv.com');
									ini_set('auth_password', 'admin1234');
									ini_set('SMTP','mail.frw.gcdsrv.com');
									ini_set('smtp_port','25');
									ini_set('sendmail_from', 'admin@frw.gcdsrv.com');
								
									//email variables
									$username = ($_POST['username']);
									$password = ($_POST['password']);
									$email = ($_POST['email']);
									$from = "admin@frw.gcdsrv.com";
									$name = "Shortlinks";
									
									// assigns email subject
									$subject = "Shortlinks Account";
									
//composes email
$body = <<<EMAIL
Dear $username

Thank you for signing up to Shortlinks.com
Your basic account has been created!

Your Username = $username
Your Password = $password
										
Get Shortening those Links!!
										
Regards,
ShortLinks team.
$from

EMAIL;
									//set headers
									$headers .= "content-type: text/html;\r\n";
									$headers .= "From: $from";

									// send the email
									mail($email, $subject, $body, $headers);
								}
								
								//prints account creation 
								print '<script> alert("Account CREATED!"); </script>';
								Print '<script> window.location.assign("FRW_LOGIN.php"); </script>';
						}
							
						//error
						else{
							print '<script> alert("User already exists!"); </script>';
							Print '<script>window.location.assign("FRW_LOGIN.php");</script>';
						}
						
					}
					
					//throws error msg.
					else{
						print '<script> alert("Password or e-mail did not match!"); </script>';
					}
				}
			}//END
?>
