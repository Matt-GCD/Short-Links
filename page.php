<?php
	session_start();//starts session
	error_reporting(E_ALL);//sends errors
	
	//sets user if user exists
	if(isset($_SESSION['username'])){
		//sets user = session user
		$user = $_SESSION['username'];
		$_SESSION['username'] = $_SESSION['username'];
	}
	
	//kill page if no user exists
	if(!isset($_SESSION['username'])){
		//redirects to login
		Print '<script> window.location.assign("FRW_LOGIN.php"); </script>';
		die();
	}
	//connects to server
	$con = mysql_connect('gcdsrv.com', 'frw', 'tefalu76', 'frw_short_links');
		if (!$con){
			//throws error if no account is found.
			die("Could not connect: " . mysql_error());
		}
	//selects database
	mysql_select_db('frw_short_links');
	//gets accounts status
	$setter = mysql_query("SELECT * FROM USERS WHERE USER_ID = '$user'") or die ($setter . "<br/><br/>" . mysql_error());//throws error if none exist
	//sets sql * from database, sets to object variable
	$row = mysql_fetch_array($setter);
	//sets status to = user status, based on the objects STATUS data
	$type = $row["STATUS"];
	//sets to session
	$_SESSION['STATUS'] = $type;
	
	if($type === "BANNED"){
		Print '<script> alert("You have been <ins>banned</ins> from this site."); </script>';
		Print '<script> window.location.assign("FRW_LOGIN.php"); </script>';
		die();
	}
	
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
	<title>Shortlinks.com Shortenr page</title>
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

<body>
	<!--Container for main content of page-->
	<div id="container" align="center">
	
	<!--Logout form-->
	<form action="FRW_LOGIN.php" method="post" align="center"><br>
		<input name="return" type="hidden" value="<?php echo urlencode($_SERVER["PHP_SELF"]);?>"/>
		<!--Logout button-->
		<button id="log" type="submit" value="logout"class="logout" style="border: 0; background: transparent"/>
		<!--Link to logout image-->
		<img src="images/logout.png" width= "100%" height="100%" alt="submit" />
		</button>
	</form><!--end of logout form-->
	
	<!--Logout php-->
	<?php
		//Ends session, closes database
		if (isset($_POST['return'])){
			//redirects to login
			$return = urldecode('FRW_LOGIN.php'.$_POST['return']);
		}
	?>		
			
	<div id="banner"> <!--Banner image for Shortlink.com -->
		<img src="images/banner.png"  align="center" alt="banner" class="center" />
	</div>
			
	<!--Sign to welcome user-->
	<h2>Welcome <?php echo "$user"?></h2>
			
	<?php
		//admin account
		if($type === "Admin"){
			echo "<p>Admin</p><br>"; 
		}
		//premium account
		if($type === "Premium"){
			echo "<p>Premium Account</p><br>"; 
		}
		//basic account
		if($type === "Basic"){
			echo"<p>Basic Account</p>"; 
		}
	?>
						
	<div id="enter_link"> <!--Enter link to shorten image-->
		<img src="images/enter_link.png"  align="center" alt="banner" class="center" />
	</div>
		
	<!--Shorten link form-->
	<form  action="shorten.php" method="post">
		<!--URL entry field-->
		<input type="url" placeholder="Enter URL " name="url" size="50" id= "URL"autocomplete="off"/>
		<!--Shorten button-->
		<button type="submit" value="Shorten" id= "shorten_button" class="Shorten" style="border: 0; background: transparent">
		<!--Link to shorten button image-->
		<img src="images/shorten_button.png" width= "100%" height="100%" alt="submit" />
		</button>
	</form><!--end of form-->
			
	<?php
		//if feedback session is set, prints link
		if(isset($_SESSION['sendURL'])){
			//prints link
			echo "<p>{$_SESSION['sendURL']}</p>";
			
			//removes link on refresh
			unset($_SESSION['sendURL']);
						
			//prints image
			echo'<div id="shortened">
					<img src="images/shortened.png"  align="center" alt="banner" class="center" />
				</div>';
		}//---ends link print---

		//sets up page based on account type	
		//prints related links
		//admin account
		if($type === "Admin"){
			echo"<a href=\"table_page.php\"><img src='images/your_links.png' alt='your_links' id= 'your_links'</a>";
			echo"<a href=\"settings.php\"><img src='images/settings.png' alt='settings' id= 'settings' ></a>";
		}
						
		//premium account
		if($type === "Premium"){
			echo"<a href=\"table_page.php\"><img src='images/your_links.png' alt='your_links' id= 'your_links'</a>";
			echo"<a href=\"settings.php\"><img src='images/settings.png' alt='settings' id= 'settings' ></a>";
		}
						
		//basic account
		if($type === "Basic"){
			echo"<a href=\"settings.php\"><img src='images/settings.png' alt='settings' id= 'settings' ></a>";
		}
	?>
	</div><!--End of main contaner-->
	
	<!--Footer-->	
	<div id="footer" align="center"> <!--Link to About page in footer -->
		<!-- About page image & link to about page-->
		<a href="about.php" id= "about">
		<img src="images/about.png" alt="about" id= "about" >
		</a>
	</div>
</body><!--denotes end of body markup-->
</html><!--denotes end of html markup-->
