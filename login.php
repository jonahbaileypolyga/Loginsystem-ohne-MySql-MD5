<?php


/*** KONFIGURATION ***/

// Definiert Konstanten für das Script
define('MD5_ENCRYPT', false); // Aktiviert Verschlüsselung für Passwort. Wenn "true" gesetzt, müssen Passwörter von $usrdata md5-verschlüsselt vorliegen. Standard: false
define('SUCCESS_URL', 'private.php'); // URL, zu welcher nach erfolgreichen Login umgeleitet wird.
define('LOGIN_FORM_URL', 'login.html'); // URL mit Anmeldeformular
// Array mit Benutzerdaten: Besteht aus Array-Elementen mit paarweisen Benutzernamen und Passwörtern
$usrdata = array(

	array(
		"usr" => "benutzer",
		"pwd" => "passwort" // MD5-verschlüsselte Form: e22a63fb76874c99488435f26b117e37
	),


);






header("Content-Type: text/html; charset=utf-8"); // Melde Browser die verwendete Zeichenkodierung

// PHP-Session starten und aktuellen Stand abfragen
session_start();
$_SESSION['logged_in'] = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) ? true : false;
$_SESSION['usr'] = (isset($_SESSION['usr'])) ? $_SESSION['usr'] : '';




$error = array();
if(!isset($_POST['login'])){
	header('Location: '.LOGIN_FORM_URL);
}else{
	$usr = (!empty($_POST['user']) && trim($_POST['user']) != '') ? $_POST['user'] : false;
	$pwd = (!empty($_POST['password']) && trim($_POST['password']) != '') ? $_POST['password'] : false;
	
	if(!$usr || !$pwd){
		if(count($error) == 0)
			$error[] = "Bitte geben Sie Benutzername und Passwort ein.";
	}else{
		$pwd = (MD5_ENCRYPT === true) ? md5($pwd) : $pwd; // Passwort eingabe MD5-encrypten, falls Option gesetzt ist
		foreach($usrdata as $ud){ // Benutzer-Liste durchlaufen und je mit Formular-Eingaben vergleichen
			if($usr != $ud['usr'] || $pwd != $ud['pwd']){
				if(count($error) == 0)
					$error[] = "Benutzername und/oder Passwort nicht korrekt.";
			}else{
				$_SESSION['logged_in'] = true;
				$_SESSION['usr'] = $usr;
				header('Location: '.SUCCESS_URL);
			}
		}
	}
}

?><!doctype html>
<html>
	<head>
		<meta name="content-type" content="text/html; charset=utf-8" />
		<title>Login-Fehler</title>
	</head>
	<body>
		<ul>
		<?php
		foreach($error as $out){
			?>
			<li><?php echo $out; ?></li>
			<?php
		}
		?>
		</ul>
		<p><a href="<?php echo LOGIN_FORM_URL; ?>">Zur Anmeldeseite</a></p>
	</body>
</html>
		