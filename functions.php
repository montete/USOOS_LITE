<?php
function Wejdz($method, $adress){
	$_POST[baseurl] = adress;
	$_POST[reqtype] = method;

	
	$ch = curl_init($_POST[baseurl]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
}
?>