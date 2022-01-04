<?php
	require("./config.php");
	if(isset($_COOKIE['UserEmail'])){
		header("Location: ./index.php");
	}
	$error=false;
	if(isset($_POST["submitLogin"])){
		$email = addslashes($_POST['email']);
		$password = md5($_POST['password']);

		$sql = "select * from user where email='$email' and password ='$password'";

		$result = $conn->query($sql);
		if ($result->num_rows == 1) {
		  setcookie("UserEmail",$email);
		  header("Location: ./index.php");
		} else {
		  $error=true;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login - CMS</title>
	<link rel="icon" href="./assets/logo.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" type="text/css" href="./style/Login.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="LoginContent">
		<form action="" method="POST" class="form">
		
			<p class="title"> 
				<i class=" bi-person-fill"></i>Login</p>
			<?php if($error==true) echo "<p class='errorLogin'>Email or password incorrect</p>";?>
			<div class="Myinputs">
				<i class="bi-envelope"></i>
				<input type="email" name="email">
			</div>
			<div class="Myinputs">
				<i class="bi-key-fill"></i>
				<input type="password" name="password">
			</div>
			<input type="submit" class="submitLogin" name="submitLogin" value="Connect">
		</form>
	</content>
</body>
</html>