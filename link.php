<?php
	error_reporting(E_ALL);//reports errors
	require_once 'shortener.php';//uses database function
		
		//if set, gets URL
		if(isset($_GET['code'])){
		
			//starts function
			$start = new Shortener;
			
			//sets code to = new_link
			$code = $_GET['code'];
				
			//gets related link; if old_link is related to new_link, send to old_link
			if($url = $start->getUrl($code)) {
					//sets views
					mysql_query("UPDATE LINKS SET VIEWS = VIEWS +1 WHERE NEW_LINK = '$code'") or die (mysql_error());
				//redirects to site, using old_link
				header("Location: {$url}");
				die();//kills page
			}
			
		}//===ends if isset===
		
?>
