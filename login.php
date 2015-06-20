<!doctype html>
<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>Login to USOOS</title>
</head>
<body style="background-color:#6698FF">
<div style ="margin:auto;position:absolute;top:0;left:0;bottom:0;right:0;width:100px;height:100px;">
<form method="post" enctype="multipart/form-data" align=center>
<table align=center>
<tr><td colspan ="2">USOOS LIGHT</td></tr>
<tr><td>login:</td><td><input type="text" name="vallogin" value="<? echo isset ($_POST [vallogin]) ? $_POST[vallogin] : ""; ?>"/></td></tr>
<tr><td>password:</td><td><input type="password" name="valpassword" value="<? echo isset ($_POST [valpassword]) ? $_POST[valpassword] : ""; ?>"/></td></tr>
<tr><td><input type="submit" value="Wyslij" /></td></tr>
<tr><td colspan="2">
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
		//echo "\nlogowanie_sukces";
		//echo $_SESSION["code"];
		header('Refresh: 1; URL=dashboard.php');
	}
}
?>
</td></tr>
</table>

</form>
</body>
</div>
</html>