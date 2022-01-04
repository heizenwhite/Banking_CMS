<?php
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profil</title>
	<link rel="icon" href="./assets/logo.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="ProfilContent">
		
	</content>
</body>
</html>