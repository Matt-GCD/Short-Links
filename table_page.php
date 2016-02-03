<?php
	session_start();//starts session
	error_reporting(E_ALL);//throws error
	
	//if set, set user = session
	if(isset($_SESSION['username'])){
		//sets user = username
		$user = $_SESSION['username'];
		$_SESSION['username'] = $_SESSION['username'];
	}
	//kill page if no user
	if(!isset($_SESSION['username'])){
		//redirect to login
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

<html lang="en">
	
<head><!--mark up for page header-->
	<meta charset="utf-8"><!--sets page format-->
	<title>Shortlinks.com your links</title><!--page name-->
	<meta name="description" content="Shortlinks.com">
	<meta name="author" content="FRW"><!--Author name -->
	<link rel="stylesheet" href="style.css"><!--Link to CSS style sheet -->
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
	<div class="container" align="center">
	
		<!--Logout form-->
		<form action="FRW_LOGIN.php" method="post" align="center"><br>
			<input name="return" type="hidden" value="<?php echo urlencode($_SERVER["PHP_SELF"]);?>"/>
			<!--Logout button-->
			<button id="log" type="submit" value="logout" class="logout" style="border: 0; background: transparent"/>
			<!--Link to logout image-->
			<img src="images/logout.png" width= "100%" height="100%" alt="submit" id="logout" />
			</button>
		</form><!--end of logout form-->
					
			<!--Logout-->
			<?php
				//Ends session, closes database
				if (isset($_POST['return'])){
					//redirects to login
					$return = urldecode('FRW_LOGIN.php'.$_POST['return']);
				}
			?>		
				
		<div id="banner"> 
			<!--Banner image for Shortlink.com -->
			<a href="page.php">
				<img src="images/banner.png"  align="center" alt="banner" class="center" />
				</a>
			</div>
				
			<!--Welcome User-->
			<h2>Welcome <?php echo "$user"?></h2>
					
			<!--premium account table-->
			<?php
				$user = $_SESSION['username'];
				//database login
				$con = mysql_connect('gcdsrv.com', 'frw', 'tefalu76', 'frw_short_links');
					if (!$con){
						die("Could not connect: " . mysql_error());
					}
				//selects database
				mysql_select_db('frw_short_links');
						
				//selecting links
				$sql_table = mysql_query("SELECT * FROM LINKS WHERE USER_ID = '$user';") or die ($sql_table."<br/><br/>" . mysql_error());
				echo "<CENTER><table style = 'width: 80%' class='styled-table'></CENTER>";
				//sets headers
				$headers = array("Created", "Your Links", "new link", "Views");
				$count = count($headers);
					//prints headers
					for($i = 0; $i < $count; $i++){
						echo "<th>";
						echo $headers[$i];
						echo "</th>";
					}
					
				//gets objects, while objects are = to user
				while( $row = mysql_fetch_array($sql_table) ){
					//prints table
					echo "<tr>";
						echo "<td width='10%' class='styled-td'>" . $row['CREATED'] . "</td>";
						echo "<td width='40%' class='styled-td'>" . $row['OLD_LINK'] . "</td>";
						echo "<td width='40%' class='styled-td'>" . "<a>" . "http://www.gcdsrv.com/~frw/link.php?code=". $row['NEW_LINK'] . "</a>" . "</td>";
						echo "<td width='10%' class='styled-td'>" . $row['VIEWS'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			?>

			<!--Search Bar-->			
			<div class="search"> <!--Search field to search submitted links quickly-->
				<span class="icon"><i class="search"></i></span>
				<form action="table_page.php" method="post">
				<!--Search input field-->
				<input id="search_table"type="search" name="search" placeholder="Search..." autocomplete="off">
				<!--Search button-->
				<button id="search_button" type="submit" value="search" class="search" style="border: 0; background: transparent"/>
				<!--Link to search_button image-->
				<img src="images/search.png" width= "100%" height="100%" alt="submit" id="logout" />
				</button>
				</form>
			</div>
					
			<!--SEARCH-->
			<?php
				if( isset($_POST['search']) ){
					$search = $_POST['search'];
					//search for url in database
					$sql_search = mysql_query("SELECT * FROM LINKS WHERE OLD_LINK ='$search'");
						//prints table
						echo"<CENTER><table style = 'width: 80%' class='styled-table'></CENTER>";
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
								echo "<td width='10%' class='styled-td'>" . $row['CREATED'] . "</td>";
								echo "<td width='40%' class='styled-td'>" . $row['OLD_LINK'] . "</td>";
								echo "<td width='40%' class='styled-td'>" . "<a>" . "http://www.gcdsrv.com/~frw/link.php?code=".$row['NEW_LINK'] . "</a>" . "</td>";
								echo "<td width='10%' class='styled-td'>" . $row['VIEWS'] . "</td>";
							echo "</tr>";
						}
					echo "</table>";
										
				}//===END===
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
