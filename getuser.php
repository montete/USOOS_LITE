<?php
	session_start();
	function getUser($id){
		
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/user";
		$_POST[reqtype] = "GET";
		$_POST[code] = "code";
		$_POST[id] = "id";
		
		$obj2 = null;
		$ch2 = curl_init($_POST[baseurl]);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
	
		$data2 = Array ();
		$data2[$_POST[id]] = $id;
		
		$data2[$_POST[code]] = $_SESSION["code"];
		//print_r($data2);
		$data2[ip]=$_SERVER[REMOTE_ADDR];
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($data2));
		$response2 = curl_exec ($ch2);
		$obj2 = json_decode($response2, true);
		
		
		echo "<tr><td>".$obj2[first_name]."</td><td>".$obj2[last_name]."</td></tr>";
			
		//print_r($obj2);
	}
		function getUserName($id){
		
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/user";
		$_POST[reqtype] = "GET";
		$_POST[code] = "code";
		$_POST[id] = "id";
		
		$obj2 = null;
		$ch2 = curl_init($_POST[baseurl]);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
	
		$data2 = Array ();
		$data2[$_POST[id]] = $id;
		
		$data2[$_POST[code]] = $_SESSION["code"];
		//print_r($data2);
		$data2[ip]=$_SERVER[REMOTE_ADDR];
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($data2));
		$response2 = curl_exec ($ch2);
		$obj2 = json_decode($response2, true);
		
		
		return $obj2[first_name];
			
		
	}
			function getUserLName($id){
		
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/user";
		$_POST[reqtype] = "GET";
		$_POST[code] = "code";
		$_POST[id] = "id";
		
		$obj2 = null;
		$ch2 = curl_init($_POST[baseurl]);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
	
		$data2 = Array ();
		$data2[$_POST[id]] = $id;
		
		$data2[$_POST[code]] = $_SESSION["code"];
		//print_r($data2);
		$data2[ip]=$_SERVER[REMOTE_ADDR];
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($data2));
		$response2 = curl_exec ($ch2);
		$obj2 = json_decode($response2, true);
		
		
		return $obj2[last_name];
			
		
	}
	function forwardId($id){
		
		$value = $id;
		echo '</td><td><input type="submit" value="members" name = '.$id.' /></td></tr>';
		
	}
?>