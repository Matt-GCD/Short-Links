<?php
	error_reporting(E_ALL);//sends errors
		require_once 'shortener.php';//uses page data
		$start = new Shortener;//calls function
		
		//if set, send link
		if( isset($_POST['url']) ){
			//sets to url
			$url = $_POST['url'];
			//if code = function url, creates link
			if($code = $start->makeURL($url)){
				//Returns link short link
				$_SESSION['sendURL'] ="<a href=\"http://www.gcdsrv.com/~frw/link.php?code={$code}\">gcdsrv.com/~frw/link.php?code={$code}</a>";
			} 
			
			//if no url found, ends error.
			else{
			$_SESSION['sendURL'] = "Invalid URL !!";
			}
		}
	//returns to main page
	header('Location:page.php');
?>
