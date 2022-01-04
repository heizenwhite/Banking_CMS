<?php
	if(isset($_GET['deconnect'])=='true'){
		setcookie("UserEmail","",-10);
		header("Location: ./index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home - CMS</title>
	<link rel="icon" href="./assets/logo.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="homeContent">
		<div class="detail">
			<p class="title">Content Management System</p>
			<p class="sousTitle">For Online Banking</p>
			<a href="./Login.php" class="LoginBtn">Check Content</a>
		</div>
	</content>
</body>
</html>