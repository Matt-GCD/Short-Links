<?php
	session_start();//starts session
	error_reporting(E_ALL);//returns errors
		
	class Shortener{
		//connection to database
		//protected $db;//protected variable
		
		//database function
		public function __construct(){
			//constructs re-useable mysql resource
			mysql_connect('gcdsrv.com', 'frw', 'tefalu76');
			//connects to database
			mysql_select_db('frw_short_links');
		}
			
		//form url
		public function makeURL($url){
			//removes white space
			$url = trim($url);
				
			//if user is set
			if(isset($_SESSION['username'])){
				//set user = username
				$user = $_SESSION['username'];
			}else{
				die();
			}
				
			//checks if url is entered and is valide URL
			if(!filter_var($url, FILTER_VALIDATE_URL)){
				return '';//if not, returns empty
			}
			
			//clears url of special char
			$url = mysql_real_escape_string($url);
				
			//Gets URL from database
			$exists = mysql_query("SELECT NEW_LINK FROM LINKS WHERE OLD_LINK = '$url';");
					
			//if it exists, return original link (checks to see if rows exist)
			if(mysql_num_rows($exists)>0){
				$row = mysql_fetch_object($exists);
				return $linknew = $row->NEW_LINK;
			}
					
			//if it doesn't exist, create new short link
			else{
				//Inserts old_link
				$user = $_SESSION['username'];
				mysql_query("INSERT INTO LINKS (OLD_LINK, CREATED, USER_ID) VALUES ('{$url}', NOW(), '$user');");
				
				//gets last set id
				$num = mysql_insert_id();
					
				//Number converted from Base 10, to base 36. returns letters (a-z) and numbers(0-9)
				$code = base_convert($num, 10, 36);

				//puts generated code into database
				mysql_query("UPDATE LINKS SET NEW_LINK = '{$code}' WHERE OLD_LINK = '{$url}';");
					
				//returns the new_link code
				return $code;
			}
		}//-------------------
			
		//To display url
		public function getUrl($code){
			//removes special characters from code
			$code = mysql_real_escape_string($code);
			//gets code from database
			$code = mysql_query("SELECT OLD_LINK FROM LINKS WHERE NEW_LINK = '$code'");
				//if exists, return url
				if(mysql_num_rows($code)>0){
					//returns old link from database
					$row = mysql_fetch_object($code);
					//returns old link
					return $linkold = $row->OLD_LINK;
					
					//set IP
					$ipaddress = '';
						if (getenv('HTTP_CLIENT_IP')){
							$ip = getenv('HTTP_CLIENT_IP');}
						else if(getenv('HTTP_X_FORWARDED_FOR')){
							$ip = getenv('HTTP_X_FORWARDED_FOR');}
						else if(getenv('REMOTE_ADDR')){
							$ip = getenv('REMOTE_ADDR');}
						else{
							$ip = 'UNKNOWN';}
						
					//insert into database
					mysql_query("INSERT INTO ID_DATA (IP,USER_ID) VALUES($ip, $user)") or die (mysql_error());
				}
				//default, return nothing
				return '';
		}//-------------------
				
	}//END CLASS
?>
