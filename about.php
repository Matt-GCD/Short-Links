<?php
	session_start();//starts session
	error_reporting(E_ALL);//sends errors
	
	//sets user if user exists
	if(isset($_SESSION['username'])){
		//sets user = session user
		$user = $_SESSION['username'];
		$_SESSION['username'] = $_SESSION['username'];
		
		//Linking SQL server & Connection to the Database
		$con = mysql_connect('gcdsrv.com', 'frw', 'tefalu76', 'frw_short_links');
			if (!$con){
				die("Could not connect: " . mysql_error());//throws error
			}
		//links database
		mysql_select_db('frw_short_links');
	}
	
	//kill page if no user exists
	if(!isset($_SESSION['username'])){
		//redirects to login
		Print '<script> window.location.assign("FRW_LOGIN.php"); </script>';
		die();
	}
	
	//if set, set account status = user database status
	if(isset($_SESSION['STATUS'])){
		$type = $_SESSION['STATUS'];
	}
	
	//picture array
	$pics = array('images/blue.png', 'images/pink.png', 'images/green.png', 'images/purple.png' );
	//random number based on the array size
	$i = rand(0, count($pics)-1);
	//selects random picture based on the number
	$pic = "$pics[$i]";	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
		<title>Shortlink.com</title>
		<meta name="description" content="Shortlinks.com">
		<meta name="author" content="FRW">
		<link rel="stylesheet" href="style.css">
		<style type="text/css">
			<!--
			body{
			background: url(<?php echo $pic; ?>) repeat;
			}
			-->
		</style>	
	</head>

	<body>
		<div id="container" align="center">
			
			<div id="banner">
			<a href="page.php">
			<img src="images/banner.png"  align="center" alt="banner" class="center" />
			</a>
			</div>
			
			<h1>About Us</h1>
			<p>How about shortening them links? Well that's what we offer you here at ShortLinks, we dedicate ourselves to you by creating a service which allows you to break a long tedious link into a short a sweet snippet for all your purposes. Sign up, sign in and start collecting them short links.</p>
			
			<div id="list" align="left">
				<h2>What do we offer?</h2>
				<ol>
				<li>Shortened URL links.</li>
					<li>A place to manage your links.</li>
					<li>A faster route to any website of your choice.</li>
					<li>An account to store your favourite URL links.</li>
				</ol>
			</div>
			
			<h2>Our Team</h2>
			<p>Here at ShortLinks.com we look to make things a little easier when it comes to links. Our team is comprised off three guys who are dedicated in doing just that, shorten that URL and don't be that person who pastes a long unprofessional URL link.</p>
			<br></br>
			<p>We are you you're shorter route. A team of well practised web developers and designers</p>
			
			<div class="Ross">
			
				<div class="image" style="background-image: url(http://images.humaan.com.au/epic/profiles/karen.jpg);"></div>
				<div class="text">
					<h3>Ross Cosgrave</h3>
					<p class="title">Co-founder &amp; Developer</p>
					<p>Input about ross</p>
					<a class="icn twitter" href="(Link to Ross Twitter)" target="_blank"><span>Ross on Twitter</span></a>
			</div>
			
			
			<div class="Matthew">
			
				<div class="image" style="background-image: url(http://images.humaan.com.au/epic/profiles/karen.jpg);"></div>
				<div class="text">
					<h3>Matthew Rice</h3>
					<p class="title">Co-founder &amp; Developer</p>
					<p>Input about Matthew</p>
					<a class="icn twitter" href="(twitter Link)" target="_blank"><span>Matthew on Twitter</span></a>
			</div>
			
			
			<div class="Fiachra">
			
				<div class="image" style="background-image: url(http://images.humaan.com.au/epic/profiles/karen.jpg);"></div>
				<div class="text">
					<h3>Fiachra Doyle</h3>
					<p class="title">Co-founder &amp; Developer</p>
					<p>Input about Fiachra</p>
					<a class="icn twitter" href="(Twitter)" target="_blank"><span>Fiachra on Twitter</span></a>
			</div>
		
		<div id="footer" align="center">
			<p id="copy">&copy; 2015 Ross Cosgrave(), Fiachra Doyle (2858577) & Matthew Rice (2861847)</p>
			</a>
		</div>
	</body>
</html>
