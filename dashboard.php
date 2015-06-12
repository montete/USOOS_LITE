<!doctype html>
<?php

session_start();
include 'getuser.php';

?>
<html>
<head>
<meta charset="utf-8">
<title>USOOS LITE</title>
</head>
<body>
<?php 
	
	$name = getUserName($_SESSION["id"]);
	$lname = getUserLName($_SESSION["id"]);
	echo '<p>Witaj '.$name.' '.$lname.'</p>';
	
?>
<form method="post" enctype="multipart/form-data" action="logout.php">
<input type="submit" value="Wyloguj" />
</form>
<?php
	$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/studorg";
	$_POST[reqtype] = "GET";
	$_POST[code] = "code";
	$obj = null;
	$ch = curl_init($_POST[baseurl]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
	
	$data = Array ();
	$data[$_POST[code]] = $_SESSION["code"];
	$data[ip]=$_SERVER[REMOTE_ADDR];
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query ($data));
	$response = curl_exec ($ch);
	
	if (isset ($_COOKIE[code])) {
		echo $_COOKIE[code];
	}
	if (!$response) {
		echo "Brak odpowiedzi";
	} elseif($response == "null") {
		echo "nie masz uprawnien do sprawdzania organizacji studenckich";
		
	} else {
		//echo "$response";
		
		$obj = json_decode($response, true);
		echo '<form method="post" enctype="multipart/form-data">';
		echo "<table border=1>";
		echo "<tr><td>id</td><td>Nazwa</td><td>Skrót</td><td>link</td><td>data utworzenia</td></tr>";
		for($i = 0; $i<count($obj); $i++){
			echo "<tr><td>".$obj[$i][id]."</td><td>".$obj[$i][name]."</td><td>".$obj[$i][short_name]."</td><td><a href='".$obj[$i][url]."'>".$obj[$i][url]."</a></td><td>".$obj[$i][reg_date];
			echo '</td></tr>';
			}
		echo "</table>";
		echo '</form>';
	}
?>
<form method="post" enctype="multipart/form-data">
<table border =1>
<tr><td>id koła</td><td>generuj listę członków</td></tr>
<tr><td><input type="text" name="number" value="<? echo isset ($_POST [number]) ? $_POST[number] : ""; ?>"></td><td><input type="submit" value="Generuj" /></td></tr>
</table>
</form>

<table border=1>
<?php	
	
		
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/member";
		$_POST[reqtype] = "GET";
		$_POST[oid] = "oid";
		$_POST[withdraw_date] = "withdraw_date";
		//$_POST[id] = "id";
		
		if(intval($_POST[number]) == 0 or intval($_POST[number]) > count($obj) ){
			echo "złe id koła";
		}else{
		$buf = null;
		$ch2 = curl_init($_POST[baseurl]);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
		//echo $_POST[number];
		$usrdata = Array ();
		$usrdata[$_POST[oid]] = $_POST[number];
		$usrdata[$_POST[withdraw_date]] = "";
		$usrdata[$_POST[code]] = $_SESSION["code"];
		//print_r($usrdata);
		$usrdata[ip]=$_SERVER[REMOTE_ADDR];
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($usrdata));
		$resp2 = curl_exec ($ch2);
		$buf = json_decode($resp2, true);
		//echo $buf[0][uid];
			
		//print_r($buf);
		echo "<tr><td>Imię</td><td>Nazwisko</td></tr>";
		for($i = 0; $i<count($buf); $i++){
				getUser(intval($buf[$i][uid]));
			}
		}
	}

?>
</table>
<?php echo "siema" ?>
</body>
