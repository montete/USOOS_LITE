<?php
session_start();
?>
<html>
<body style="background-color:#6698FF">
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
	//nazyw pól
	$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/logout";
	$_POST[reqtype] = "POST";
	$_POST[code] = "code";
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
		echo "wylogowano";
		header('Refresh: 1; URL=login.php');
	} else {
		//echo "$response";
		echo "wylogowano";
		header('Refresh: 1; URL=login.php');
	}
}

?>
</body>
</html>