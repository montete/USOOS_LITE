<!doctype html>
<?php

session_start();
include 'getuser.php';
function is_empty($var)
{ 
 return empty($var);
}
?>
<html>
<head>
<meta charset="utf-8">
<title>USOOS LITE</title>
</head>
<body style="background-color:#6698FF">
<?php 
	
	$name = getUserName($_SESSION["id"]);
	$lname = getUserLName($_SESSION["id"]);
	echo '<p>Witaj '.$name.' '.$lname.'</p>';
	
?>
<form method="post" enctype="multipart/form-data" action="logout.php">
<input type="submit" value="Wyloguj" />
</form>
<?php

function addOrganisation() {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/studorg";
		$_POST[reqtype] = "POST";
		
		$buf = null;
		$ch2 = curl_init($_POST[baseurl]);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);

		$usrdata = Array ();
		$usrdata["name"] = $_POST[name];
		$usrdata["short_name"] = $_POST[short_name];
		if( $_POST[url] != "" ) {
		$usrdata["url"] = $_POST[url];
		}
		if( $_POST[ouid] != "" ) {
		$usrdata["ouid"] = $_POST[ouid];
		}
		
		$usrdata["code"] = $_SESSION["code"];
		$usrdata[ip]=$_SERVER[REMOTE_ADDR];
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($usrdata));
		$response2 = curl_exec ($ch2);
		if( !$response2 ) {
			echo( "Brak odpowiedzi" );
		}
		elseif( $response2 == "null" ) {
			?>
			<p><a href="?mode=default">Powrót</a></p>
			<?php
			echo( "User Already here<br />" );
		}
		else {
		$buf = json_decode($resp2, true);
		echo("Organizacja ".$usrdata["name"]." została dodana pomyślnie!<br />");
		}
	}
}

function addMemberToOrganisation() {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/member";
		$_POST[reqtype] = "POST";
		
		$buf = null;
		$ch2 = curl_init($_POST[baseurl]);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);

		$usrdata = Array ();
		$usrdata["oid"] = $_POST[oid];
		$usrdata["uid"] = $_POST[uid];
		
		$usrdata["code"] = $_SESSION["code"];
		$usrdata[ip]=$_SERVER[REMOTE_ADDR];
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($usrdata));
		$response2 = curl_exec ($ch2);
		if( !$response2 ) {
			echo( "Brak odpowiedzi" );
		}
		elseif( $response2 == "null" ) {
			?>
			<p><a href="?mode=default">Powrót</a></p>
			<?php
			echo( "Brak uprawnień użytkownika lub jest błąd na serwerze Pawła :P<br />" );
		}
		else {
		$buf = json_decode($resp2, true);
		echo("Użytkownik został pomyślnie dodany do organizacji!<br />");
		header('Refresh: 1; URL=dashboard.php?mode=studorgs-members');
		}
	}
}

function showOrganisations() {
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
		?>		
		<p><a href="?mode=default">Powrót</a></p>
		<?php
		echo "nie masz uprawnien do sprawdzania organizacji studenckich";
		echo '<p><a href="?mode=default">Powrót</a></p>';
		
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
}

function showDocuments() {
	$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/document";
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
	echo('<p><a href="?mode=default">Powrót</a></p>');
	if (!$response) {
		echo "Brak odpowiedzi";
	}
	elseif($response == "null") {
		echo("Brak uprawnień lub błąd na serwerze Pawła :P !");
	}
	else {
		$obj = json_decode($response, true);
		echo '<form method="post" enctype="multipart/form-data">';
		echo "<table border=1>";
		echo "<tr><td>id</td><td>Tytuł dokumentu</td><td>ID właściciela</td><td>ID organizacji studenckiej</td><td>Parametr dokumentu (INT(6))</td><td>Parametr dokumentu (TIMESTAMP)</td><td>ID typu dokumentu</td><td>Status dokumentu</td><td>Data utworzenia</td><td>Data ostatniej modyfikacji</td><td>Data zgłoszenia dokumentu</td><td>Data akceptacji dokumentu</td></tr>";
		for($i = 0; $i<count($obj); $i++){
			echo "<tr><td>".$obj[$i][id]."</td><td>".$obj[$i][title]."</td><td>".$obj[$i][oid]."</td><td>".$obj[$i][soid]."</td><td>".$obj[$i][i_arg]."</td><td>".$obj[$i][d_arg]."</td><td>".$obj[$i][doctype]."</td><td>".$obj[$i][status]."</td><td>".$obj[$i][createDate]."</td><td>".$obj[$i][lastEditDate]."</td><td>".$obj[$i][submitDate]."</td><td>".$obj[$i][examineDate];
			echo '</td></tr>';
			}
		echo "</table>";
		echo '</form>';
	}
}

function getAllUsers() {
	
	$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/user";
	$_POST[reqtype] = "GET";
	$_POST[code] = "code";
	
	$obj2 = null;
	$ch2 = curl_init($_POST[baseurl]);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch2, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);

	$data2 = Array ();
	$data2[$_POST[code]] = $_SESSION["code"];
	$data2[ip]=$_SERVER[REMOTE_ADDR];		
	curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query ($data2));
	$response2 = curl_exec ($ch2);
	$obj2 = json_decode($response2, true);
	for( $i = 0; $i < count($obj2); $i++ ) {
		echo('<option value="'.$obj2[$i][id].'">'.$obj2[$i][first_name].' '.$obj2[$i][last_name].'</option>');
	}
}

function insertNewMember($oid) {
	?>
	<form method="post" enctype="multipart/form-data" action="?mode=studorgs-addnewmember">
	<table border =1>
	<p>Dodaj członków do tej organizacji:</p>
	<tr><td>Nazwa użytkownika</td><td></td></tr>
	<tr><td><select name="uid"><? getAllUsers(); ?></select><input type="hidden" name="oid" value="<? echo($oid); ?>"><input type="hidden" name="mode" value="studorgs-addnewmember" /></td><td><input type="submit" value="Dodaj" /></td></tr>
	</table>
	</form>
	<?php
}

function showMembersOfOrganisation() {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/member";
		$_POST[reqtype] = "GET";
		$_POST[oid] = "oid";
		$_POST[withdraw_date] = "withdraw_date";
		//$_POST[id] = "id";
		
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
		if( count($buf) <= 0 ) {
			echo("<p>Brak członków koła.</p>");
			//echo $_POST[number];
			insertNewMember($_REQUEST[number]);	
		}
		else {
			?>
			<p>Lista członków organizacji:</p>
			<table border=1>
			<tr><td>Imię</td><td>Nazwisko</td></tr>
			<?php
			for($i = 0; $i<count($buf); $i++){
				getUser(intval($buf[$i][uid]));
			}
			?>
			</table>
			<?php
			insertNewMember($_REQUEST[number]);			
		}
	}
}
function SeeAllOrganisationUnits($oid) {
	
	$_POST[baseurl] = "http://www.astrouw.edu.pl/knastr/usoos/orgunit";
	$_POST[reqtype] = "GET";
	$_POST[code] = "code";
	$_POST[id] = "id";
	
	$buf = null;
	$chf = curl_init($_POST[baseurl]);
	curl_setopt($chf, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($chf, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($chf, CURLOPT_CUSTOMREQUEST, $_POST[reqtype]);
	$orgdata = Array();
	$orgdata[$_POST[id]] = $oid;
	$orgdata[$_POST[code]] = $_SESSION["code"];
	$orgdata[ip]=$_SERVER[REMOTE_ADDR];
	curl_setopt($chf, CURLOPT_POSTFIELDS, http_build_query ($orgdata));
	$resp3 = curl_exec ($chf);
	$buf = json_decode($resp3,true);
	
	return $buf;
}

if( !(isset($_REQUEST["mode"])) || ($_REQUEST["mode"] == "default") ) {
echo("
	<h3>Panel administracyjny</h3>
	<ul>
	<li style=\"list-style-type: none\"><a href=\"?mode=studorgs-view\">Lista organizacji studenckich - wyświetlanie i dodawanie</a></li>
	<li style=\"list-style-type: none\"><a href=\"?mode=studorgs-members\">Organizacje studenckie - członkowie</a></li>
	<li style=\"list-style-type: none\"><a href=\"?mode=orgunit-view\">Jednostki Organizacyjne</a></li>
	<li style=\"list-style-type: none\"><a href=\"?mode=listoffiles\">Lista dokumentów organizacji</a></li>
	</ul>
");
}
else if( $_REQUEST["mode"] == "studorgs-view" ) {
	addOrganisation();
	echo('<p><a href="?mode=default">Powrót</a></p>');
	showOrganisations();
	?>
	<form method="post" enctype="multipart/form-data">
	<table border =1>
	<tr><td>Nazwa koła</td><td>Nazwa skrócona</td><td>Strona internetowa koła</td><td>Jednostka organizacyjna (id)</td><td>dodaj</td></tr>
	<tr><td><input type="text" name="name" value="<? echo isset ($_POST [name]) ? $_POST[name] : ""; ?>"></td><td><input type="text" name="short_name" value="<? echo isset ($_POST [short_name]) ? $_POST[short_name] : ""; ?>"></td><td><input type="text" name="url" value="<? echo isset ($_POST [url]) ? $_POST[url] : ""; ?>"></td><td><input type="text" name="ouid" value="<? echo isset ($_POST [ouid]) ? $_POST[ouid] : ""; ?>"></td><td><input type="submit" value="Dodaj" /></td></tr>
	</table>
	</form>
	<?php	
}
else if( $_REQUEST["mode"] == "studorgs-members" ) {
?>
	<p><a href="?mode=default">Powrót</a></p>
	<form method="post" enctype="multipart/form-data" action=?>
	<table border =1>
	<tr><td>id koła</td><td>generuj listę członków</td></tr>
	<tr><td><input type="text" name="number" value="<? echo isset ($_POST [number]) ? $_POST[number] : ""; ?>"></td><td><input type="hidden" name="mode" value="studorgs-members" /><input type="submit" value="Generuj" /></td></tr>
	</table>
	</form>
	<?php
	showMembersOfOrganisation();
}
else if( $_REQUEST["mode"] == "studorgs-addnewmember" ) {
	//insertNewMember($_REQUEST[number]);
	addMemberToOrganisation();
}
else if($_REQUEST["mode"] == "orgunit-view"){
	?>
	<p><a href="?mode=default">Powrót</a></p>
	<?php
	$ids = 0;
	$bud = SeeAllOrganisationUnits(10);
	?>
	<table border =1>
	<tr><td>id</td><td>Nazwa</td><td>nazwa_skrocona</td><td>url</td></tr>
	<?php
	while(1){
		$ids++;
		$bud = SeeAllOrganisationUnits($ids);
		if(is_empty($bud)){
			echo "</table>";
			break;
		}
		echo "<tr><td>".$bud[id]."</td><td>".$bud[name]."</td><td>".$bud[short_name]."</td><td><a href='".$bud[url]."'>".$bud[url]."</a></td></tr>";
	}
}
else if( $_REQUEST["mode"] == "listoffiles") {
	showDocuments();
}

?>
</body>
</html>