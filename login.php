<!doctype html>
<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>Zaloguj siê do USOOS</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
<table>
<tr><td>login:</td><td><input type="text" name="vallogin" value="<? echo isset ($_POST [vallogin]) ? $_POST[vallogin] : ""; ?>"/></td></tr>
<tr><td>password:</td><td><input type="text" name="valpassword" value="<? echo isset ($_POST [valpassword]) ? $_POST[valpassword] : ""; ?>"/></td></tr>
</table>
<input type="submit" value="Wyslij" />
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	


	
	$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/login";
	$_POST[reqtype] = "POST";

	
	$ch = curl_init($_POST[baseurl]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);

	//echo $ch;
	$_POST[login] = "login";
	$_POST[password] = "password";
	$data = Array ();
	$data[$_POST[login]] = $_POST[vallogin];
	$data[$_POST[password]] = $_POST[valpassword];  
	//print_r($data);
	$data[ip]=$_SERVER[REMOTE_ADDR];
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query ($data));
	$response = curl_exec ($ch);
	if (isset ($_COOKIE[code])) {
		//echo $_COOKIE[code];
	}
	if (!$response) {
		echo "Brak odpowiedzi";
	} elseif($response == "null") {
		echo "bad login or password";
		
	} else {
		//echo "$response";
		$obj = json_decode($response, true);
		$_SESSION["code"] = $obj["code"];
		$_SESSION ["id"] = $obj["id"];
		echo "\nlogowanie_sukces";
		//echo $_SESSION["code"];
		header('Refresh: 1; URL=dashboard.php');
	}
}
?>
