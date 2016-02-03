<?php
    if (!isset($_SESSION)){
    session_start();
    }
    $_SESSION['username'] = '';

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

<head> <!--mark up for page header-->
    <meta charset="utf-8"><!--sets page format-->
    <title>Shortlink.com Login</title><!--page name-->
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

<body>
	<!--Container for main content of page-->
	<div id="container" style="text-align: center">
        <div id="banner">
		<!--Banner image for Shortlink.com -->
        <img align="center" alt="banner" class="center" src="images/banner.png">
		</div>
		
		<!--Sign in form for existing users to login-->
        <div id="sign-in" style="text-align: center">

            <form action="FRW_LOGIN.php" method="post">
                <!--Username entry field-->
				<input id="enter_username" name="username" placeholder="Enter Username" required="required" size="50" type="text"> 
                <!--Password entry field-->
				<input id="enter_password" name="password" placeholder="Enter Password" required="required" size="50" type="password">
                <!--Submit button-->
                <button class="sign_in_button" id="sign_in_button" style="border: 0; background: transparent" type="submit" value="submit">
				<!--Link to sign in image-->
				<img alt="submit" height="100%" src="images/sign_in_button.png" width="100%">
				</button>
            </form>
        </div><!--End of form-->

        <div id="or">
		<!--Image for Or in the centre of page-->
        <img align="center" alt="banner" class="center" src="images/or.png">
		</div>
		
		<!--Sign up button image & link to sign up page-->
		<a href="SIGN_UP.php">
		<img alt="signup" id="sign_up_button" src="images/sign_up_button.png">
		</a>
    </div>
	
	<!--Footer-->
    <div id="footer" style="text-align: left">
        <!-- About page image & link to about page-->
        <a href="about.php" id="about">
		<img alt="about" id="about" src="images/about.png">
		</a>
    </div>
	
	<?php //PHP MARK-UP
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
                if($_SERVER["REQUEST_METHOD"] === "POST"){
                    //USER_ID USER_PASSWORD
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
                        $count_pass = mysql_num_rows($result_pass);
                        
                    //password correct
                        if($count_pass > 0){
                        //sends to account
                            $_SESSION['username'] = $username;
                        //sends to account
                            Print '<script>window.location.assign("page.php");</script>';
                        }
                    //password error
                        else{
                            echo "Error, re-type Username and Password!";
                        }
                    }
                    
                //throws error msg
                    else{
                        //print '<script> alert("ERROR: No Account Found!"); </script>';
                    }
                    
                }//END
    ?><!--Logout-->
    <?php
                    //Ends session, closes database
                    if (isset($_POST['return'])) {
                        $return = urldecode('FRW_LOGIN.php'.$_POST['return']);
                        mysql_close($con);
                        session_destroy(); 
                }
                ?>
</body><!--denotes end of body markup-->
</html><!--denotes end of html markup-->
