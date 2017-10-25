<?php
session_start();
if(!$_SESSION['logged_in'])
	header("Location: login.html");
?><!doctype html>
<html>
	<head>
		<meta name="content-type" content="text/html; charset=utf-8" />
		<title>Privater Bereich</title>
	</head>
	<body>
		<h1>Willkommen <?php echo $_SESSION['usr']; ?>!</h1>
		<h2>Sie haben sich erfolgreich angemeldet.</h2>
		<p>Dies ist der passwortgeschützte Bereich Ihrer Website.</p>
		<p><a href="logout.php">Melden sie sich wieder ab.</a></p>
	</body>
</html>