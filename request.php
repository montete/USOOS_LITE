<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Test</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
<label for="baseurl">Podstawowy adres serwera USOOS:</label><input type="text" name="baseurl" value="<? echo isset ($_POST [baseurl]) ? $_POST[baseurl] : ""; ?>"/><br />
<label for="page">Strona:</label><input type="text" name="page" value="<? echo isset ($_POST [page]) ? $_POST[page] : ""; ?>"/><br />
<label for="url">Zadanie:</label><input type="text" name="reqtype" value="<? echo isset ($_POST [reqtype]) ? $_POST[reqtype] : ""; ?>" /><br />
<table>
<tr><th>Atrybut</th><th>Wartosc</th></tr>
<tr><td><input type="text" name="attr1" value="<? echo isset ($_POST [attr1]) ? $_POST[attr1] : ""; ?>"></td><td><input type="text" name="val1" value="<? echo isset ($_POST [val1]) ? $_POST[val1] : ""; ?>"/></td></tr>
<tr><td><input type="text" name="attr2" value="<? echo isset ($_POST [attr2]) ? $_POST[attr2] : ""; ?>"></td><td><input type="text" name="val2" value="<? echo isset ($_POST [val2]) ? $_POST[val2] : ""; ?>"/></td></tr>
<tr><td><input type="text" name="attr3" value="<? echo isset ($_POST [attr3]) ? $_POST[attr3] : ""; ?>"></td><td><input type="text" name="val3" value="<? echo isset ($_POST [val3]) ? $_POST[val3] : ""; ?>"/></td></tr>
<tr><td><input type="text" name="attr4" value="<? echo isset ($_POST [attr4]) ? $_POST[attr4] : ""; ?>"></td><td><input type="text" name="val4" value="<? echo isset ($_POST [val4]) ? $_POST[val4] : ""; ?>"/></td></tr>
<tr><td><input type="text" name="attr5" value="<? echo isset ($_POST [attr5]) ? $_POST[attr5] : ""; ?>"></td><td><input type="text" name="val5" value="<? echo isset ($_POST [val5]) ? $_POST[val5] : ""; ?>"/></td></tr>
<tr><td><input type="text" name="attr6" value="<? echo isset ($_POST [attr6]) ? $_POST[attr6] : ""; ?>"></td><td><input type="text" name="val6" value="<? echo isset ($_POST [val6]) ? $_POST[val6] : ""; ?>"/></td></tr>
<tr><td><input type="text" name="attr7" value="<? echo isset ($_POST [attr7]) ? $_POST[attr7] : ""; ?>"></td><td><input type="text" name="val7" value="<? echo isset ($_POST [val7]) ? $_POST[val7] : ""; ?>"/></td></tr>
<tr><td><label for="contents">Dokument:</label></td><td><input type="file" name="contents" id="contents"></td></tr>
</table>
<input type="submit" value="Wyslij" />
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_FILES['contents'][name]) {
    $temp = $_FILES[contents][tmp_name];
    $fp = fopen ($temp, 'r');
    $contents = base64_encode((fread($fp, filesize($temp))));
    //echo $_FILES['contents'][name];
    //echo $contents;
    fclose($fp);
  }
  //$data = array("id" => 1);
  //echo  $this->_serviceUrl;
  //$ch = curl_init("http://www.astrouw.edu.pl/knastr/usoos/user.php");
  $ch = curl_init($_POST[baseurl].$_POST[page]);
  //$ch = curl_init("http://iem.pw.edu.pl/~polanskp/usoos.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
  //curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
  //curl_setopt($ch, CURLOPT_COOKIE, "code={$_COOKIE[code]}");
  //if ($_POST[reqtype] == "POST") {
  //  curl_setopt($ch, CURLOPT_POST, 1); 
  //} else {
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
  //}
  //curl_setopt ($ch, CURLOPT_POST, 1);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query ($data));
  $data = Array ();
  //array_slice ($_POST, 2);
  for ($i = 1; $i < 7; $i++) {
    if ($_POST['attr'.$i]) {
      $data[$_POST['attr'.$i]] = $_POST['val'.$i];
    }
  }
  if (isset ($contents)) {
    if (!isset ($data['fname'])) {
      $data[fname] = $_FILES[contents][name];
    }
    $data['contents'] = $contents;
  }
  print_r($data);
  $data[ip]=$_SERVER[REMOTE_ADDR];
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query ($data));
  $response = curl_exec ($ch);
  if (isset ($_COOKIE[code])) {
    echo $_COOKIE[code];
  }
  if (!$response) {
    echo "Brak odpowiedzi";
  } else {
    echo "Odpowiedz serwera:<br />";
	//$obj = json_decode($response, true);
	var_dump(json_decode($response, true));
    //echo "$response";
  }
}
?>
</body>