<?php
	session_start();//starts session
	error_reporting(E_ALL);//sends errors
	
	//if user is set, set user = username
	if(isset($_SESSION['username'])){
		//sets session
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
	//if not set, send back to login
	if(!isset($_SESSION['username'])){
		//redirects back to login
		Print '<script> window.location.assign("FRW_LOGIN.php"); <script>';
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
<!--html page mark up-->
<html lang="en">

<head><!--mark up for page header-->
	<meta charset="utf-8"><!--sets page format-->
	<title>Shortlinks.com</title><!--sets page format-->
	<meta name="description" content="Shortlinks.com">
	<meta name="author" content="FRW"><!--Author name -->
	<link href="images/icon.png" rel="icon" sizes="16x16" type="image/png"><!--Link to image to appear in tab on browser -->
	<link rel="stylesheet" href="style.css">
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
		<img src="images/logout.png" width= "100%" height="100%" alt="submit" id="logout" />
		</button>
	</form><!--end of logout form-->
				
	<!--Logout-->
		<?php
			//Ends session, closes database
			if (isset($_POST['return'])){
					$return = urldecode('FRW_LOGIN.php'.$_POST['return']);
			}
		?>	
						
			<a href="page.php">
				<div id="banner"> <!--Banner image for Shortlink.com -->
				<img src="images/banner.png"  align="center" alt="banner" class="center" />
				</a>
				</div>
			</a>
			
			<?php
				//user accounts types
				//each account has different setting types
				//admin can delete links, plus other functions.
				//premium can view links and search database.
				//basic can only create short links.
				
				//BASIC
				if($type === "Basic"){
					echo'<div class="status">
							<img src=\'images/premium_account.png\' alt=\'premium\' id= \'premium\' ></a>
							<form style="margin: 0em; padding: 0em;" action="settings.php" method="post">
								<table style="width:auto">
								  <tr>
									<td><h4>Username: <h3/></td>
									<td><input style="display: inline;" type="text" name="username" size="40" required="required"/></td> 
								  </tr>
								  <tr>
									<td><h4>Password: <h3/></td>
									<td><input style="display: inline;" type="password" name="password" size="40" required="required" /></td> 
								  </tr>
								</table>
								<input id= "go" type="submit" name="premium" value="submit"/>
							</form>
						</div>';
				}
				//PREMIUM
				if($type === "Premium"){
					echo'<div class="status">
							<img src=\'images/basic_account.png\' alt=\'basic\' id= \'basic\' ></a>
							<form style="margin: 0em; padding: 0em;" action="settings.php" method="post">
								<table style="width:auto">
								  <tr>
									<td><h4>Username: <h3/></td>
									<td><input style="display: inline;" type="text" name="username" size="40" required="required"/></td> 
								  </tr>
								  <tr>
									<td><h4>Password: <h3/></td>
									<td><input style="display: inline;" type="password" name="password" size="40" required="required" /></td> 
								  </tr>
								</table>
								<input id= "go" type="submit" name="basic" value="submit"/>
							</form>
						</div><br>';
						
					//Deletes Links
					echo'<div class="Delete">
						<h2>Delete Your Links</h2>
							<form action="settings.php" method="post" align="center">
							<br><h3>Delete Link: <input type="text" name="Del_link" placeholder="Delete..." auto complete="off"></h3>
								<input type="submit" value="Delete"/></br>
							</form>
						</div>';
				}//---------------------------------------
				
				//PREMIUM ONLY
				//DELETING METHODS
				if(isset($_POST["Del_link"])){
					//assigns value to delete
					$delete = $_POST['Del_link'];
					//sets the user check
					$check = mysql_query("SELECT * FROM LINKS WHERE OLD_LINK = '$delete'") or die ($check . "<br/><br/>" . mysql_error());
					$row = mysql_fetch_array($check);
					$users_link = $row['USER_ID'];
					//set user
					$user = $_SESSION['username'];
					
					//checks if user owns the link
					if($users_link === $user){
						//deletes link
						mysql_query("UPDATE LINKS SET USER_ID ='Admin' WHERE OLD_LINK = '$delete'") or die (mysql_error());
						//prints if deleted
						Print '<script> alert("Link Deleted"); </script>';
					}
					else{
						Print '<script> alert("This Link does not belong to your account!"); </script>';
					}
				}
				
		//-------------------------------------------------------------------------		
				//ADMIN
				if($type === "Admin"){
					//Search for user or links
					echo'<div class="Search">
						<h2>Search For Links & Users</h2>
							<form action="settings.php" method="post" align="center">
								<br><h3>Search: </h3>
								<input type ="text" name ="Search" placeholder="Search..." autocomplete="off">
									<select name="search_items">
										<option value="Link">Link</option>
										<option value="User">User</option>
										<option value="Stat">Status</option>
									</select>
								<input type="submit" value="Search"/></br>
							</form>
						</div>';

					//ADMIN ONLY
					//Search METHODS
					if(isset($_POST["search_items"])){
						//assigns value to check if link or user
						$search_val = $_POST["search_items"];
						
						//searches link
						if($search_val === "Link"){
							//assigns value to search
							$Search = $_POST["Search"];
							
							//search for url in database
							if($Search === "All"){
								$sql_search = mysql_query("SELECT * FROM LINKS") or die ($sql_search."<br/><br/>" . mysql_error());
							}else{
								$sql_search = mysql_query("SELECT * FROM LINKS WHERE OLD_LINK = '$Search'") or die ($sql_search."<br/><br/>" . mysql_error());
							}	
								//prints table
								echo"<table style = 'width: 90%' border = '2'>";
								//prints headers
								$headers = array("Created", "Org Links", "Short link", "Views");
								$count = count($headers);
									for($i = 0; $i < $count; $i++){
										echo "<th>";
										echo $headers[$i];
										echo "</th>";
									}
								//gets objects, all prints objects
								while( $row = mysql_fetch_array($sql_search) ){
									//prints table, while obeject = searched link
									echo "<tr>";
										//prints objects
										echo "<td width='10%'>" . $row['CREATED'] . "</td>";
										echo "<td width='30%'>" . $row['OLD_LINK'] . "</td>";
										echo "<td width='30%'>" . "<a>" . "gcdsrv.com/~frw/redirect.php?code=".$row['NEW_LINK'] . "</a></td>";
										echo "<td width='10%'>" . $row['VIEWS'] . "</td>";
									echo "</tr>";
								}
						}
						//searches user
						if($search_val === "User"){
							//assigns value to search
							$Search = $_POST["Search"];
							//search for user in database
							if($Search === "All"){
								$sql_search = mysql_query("SELECT * FROM DETAILS") or die ($sql_search."<br/><br/>" . mysql_error());
							}else{
								$sql_search = mysql_query("SELECT * FROM DETAILS WHERE USER = '$Search'") or die ($sql_search."<br/><br/>" . mysql_error());
							}
								//prints table
								echo"<table style = 'width: 90%' border = '2'>";
								//prints headers
								$headers = array("User ID", "First Name", "Second Name", "Email");
								$count = count($headers);
									for($i = 0; $i < $count; $i++){
										echo "<th>";
										echo $headers[$i];
										echo "</th>";
									}
								
								//gets objects, all prints objects
								while( $row = mysql_fetch_array($sql_search) ){
									//prints table, while obeject = searched link
									echo "<tr>";
										//prints objects
										echo "<td width='20%'>" . $row['USER'] . "</td>";
										echo "<td width='20%'>" . $row['F_NAME'] . "</td>";
										echo "<td width='20%'>" . $row['S_NAME'] . "</a>" . "</td>";
										echo "<td width='30%'>" . $row['USER_EMAIL'] . "</td>";
									echo "</tr>";
								}
						}
						//Account status
						if($search_val === "Stat"){
							//assigns value to search
							$Search = $_POST["Search"];
							//search for user in database
							if($Search === "All"){
								$sql_search = mysql_query("SELECT * FROM USERS") or die ($sql_search."<br/><br/>" . mysql_error());
							}else{
								$sql_search = mysql_query("SELECT * FROM USERS WHERE USER_ID = '$Search'") or die ($sql_search."<br/><br/>" . mysql_error());
							}
								//prints table
								echo"<table style = 'width: 90%' border = '2'>";
								//prints headers
								$headers = array("User ID", "Account Status");
								$count = count($headers);
									for($i = 0; $i < $count; $i++){
										echo "<th>";
										echo $headers[$i];
										echo "</th>";
									}
								
								//gets objects, all prints objects
								while( $row = mysql_fetch_array($sql_search) ){
									//prints table, while obeject = searched link
									echo "<tr>";
										//prints objects
										echo "<td width='20%'>" . $row['USER_ID'] . "</td>";
										echo "<td width='20%'>" . $row['STATUS'] . "</td>";
									echo "</tr>";
								}
						}
					}//end search
					
					//ADMIN ONLY
					//Deletes Links and Users
					echo'<div class="Delete">
						<br><h2>Delete Links & Users</h2>
							<form action="settings.php" method="post" align="center">
								<br><h3>Delete: </h3>
								<input type="text" name="Delete" placeholder="Delete..." auto complete="off">
									<select name="delete_items">
										<option value="Link">Link</option>
										<option value="User">User</option>
									</select>
								<input type="submit" value="Delete"/></br>
							</form>
						</div>';
								
					//ADMIN ONLY
					//DELETING METHODS
					if(isset($_POST["delete_items"])){
						//assigns value to check if link or user
						$delete_items = $_POST["delete_items"];
						
						//deletes link
						if($delete_items === "Link"){
							//assigns value to delete
							$delete = $_POST["Delete"];
							//deletes link
							mysql_query("DELETE FROM LINKS WHERE OLD_LINK = '$delete'") or die (mysql_error());
							//prints if deleted
							Print '<script> alert("Link Deleted"); </script>';
						}
						//deletes user
						if($delete_items === "User"){
							//assigns value to delete
							$delete = $_POST["Delete"];
							//re-assign links to admin
							mysql_query("UPDATE LINKS SET USER_ID = 'Admin' WHERE USER_ID = '$delete'") or die (mysql_error());
							//delete user
							mysql_query("DELETE FROM DETAILS WHERE USER = '$delete'") or die (mysql_error());
							mysql_query("DELETE FROM USERS WHERE USER_ID = '$delete'") or die (mysql_error());
							//prints if deleted
							Print '<script> alert("User Deleted"); </script>';
						}
					}//end delete
					
					//ADMIN ONLY
					//Ban User
					echo'<div class="Ban">
						<br><h2>Ban User</h2>
							<span class="icon"><i class="ban"></i></span>
								<form action="settings.php" method="post">
									<input type="text" name="ban" placeholder="Ban..." autocomplete="off">
									<input type="submit" value="ban" placeholder="Ban..." autocomplete="off">
								</form>
						</div>';
					
					//ADMIN ONLY!!
					//Ban User
					if(isset($_POST['ban'])){
						//assign variable to posted data
						$ban = $_POST['ban'];
						//set status to 'BANNED'
						mysql_query("UPDATE USERS SET STATUS ='BANNED' WHERE USER_ID ='$ban'") or die (mysql_error());
						//print id banned
						Print '<script> alert("User Banned!"); </script>';
					}
					
					//ADMIN ONLY
					//send email
					echo'<br>
					<h3><ins>E-Mail</ins></h3>
					<form method="post">
						  Email: <input name="email" type="text" /><br />
						  Subject: <input name="subject" type="text" /><br />
						  Message:<br />
						  <textarea name="comment" rows="15" cols="40"></textarea><br />
						  <input type="submit" value="Submit" />
					  </form>';

					//if "email" variable is filled out, send email
						if (isset($_POST['email']))  {  
							//Email information
							ini_set('auth_username', 'admin@frw.gcdsrv.com');
							ini_set('auth_password', 'admin1234');
							ini_set('SMTP','mail.frw.gcdsrv.com');
							ini_set('smtp_port','25');
							ini_set('sendmail_from', 'admin@frw.gcdsrv.com');

							//email variables
							$from = "admin@frw.gcdsrv.com";	
							$email = $_POST['email'];
							$subject = $_POST['subject'];
							$message = $_POST['comment'];

//compose email
$body= <<<msg
	Dear User,

	$message
											
	Regards,
	ShortLinks team.
	$from
	
msg;
							//set headers	
							$headers .= "content-type: text/html;\r\n";
							$headers .= "From: $from";
				
							//send mail
							mail($email, $subject, $body, $headers);
						}				
					
				}//===END Admin Rights===
			?>
	<!--Footer-->	
	<div id="footer" align="center"> <!--Link to About page in footer -->
		<!-- About page image & link to about page-->
		<a href="about.php" id= "about">
		<img src="images/about.png" alt="about" id= "about" >
		</a>
	</div>	
</body><!--denotes end of body markup-->
<footer>

</footer>
</html><!--denotes end of html markup-->


<?php //PHP MARK-UP	
		//if request is sent by post, complete
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if($type === "Premium" or $type === "Basic"){
				//USER_ID USER_PASSWORD
				if(isset($_POST['username'])){
					$username = ($_POST['username']);
					$password = ($_POST['password']);
					
					//query to check if account exists. returns count.
					$query_old = "SELECT * FROM USERS WHERE USER_ID = '$username'";
					$result = mysql_query($query_old) or die('Error');
					$count = mysql_num_rows($result);
				
					//checks if exists; if yes, proceeds to session.
					if($count > 0){
						//password check
						$query_pass = "SELECT * FROM USERS WHERE USER_ID = '$username' AND PASSWORD = '$password'";
						$result_pass = mysql_query($query_pass) or die('Error');
						//gets row numer
						$count_pass = mysql_num_rows($result_pass);
						
						//if rows exist, complete
						if($count_pass > 0){
							//If empty, sets user status = premium
							if(!empty($_POST['premium'])){
								//sets to premium
								$set_premium = "UPDATE USERS SET STATUS = 'Premium' WHERE USER_ID ='$username'";
								mysql_query($set_premium);
								
								//redirects
								Print '<script>alert("You now have a Premium Account!!")</script>';
								Print '<script> window.location.assign("page.php"); </script>';
							}
							
							//If empty sets user status = basic
							if(!empty($_POST['basic'])){
								//sets to basic
								$set_basic = "UPDATE USERS SET STATUS = 'Basic' WHERE USER_ID ='$username'";
								mysql_query($set_basic);
								
								//redirects
								Print '<script>alert("Your account is now Basic!")</script>';
								Print '<script> window.location.assign("page.php"); </script>';
							}	
						}
						//throws error
						else{
							Print '<script> alert("Error, re-type Username and Password!"); </script>';
						}
					}
					
					//throws error
					else{
						print '<script> alert("ERROR: No Account Found!"); </script>';
					}
				}
			}
		}
?>
