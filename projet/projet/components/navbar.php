<?php
	$connected=false;
?>
<nav>
	<div class="logo">
		<img src="./assets/logo.png">
		<p class="title">Fast <span>Cashout</span></p>
	</div>
	<ul class="menu">
		<a href="./"><li>Home</li></a>
		<a href="./Campany.php"><li>Company</li></a>
		<a href="./Agence.php"><li>Agence</li></a>
		<a href="./Transactions.php"><li>Transactions</li></a>
		<a href="./Customer.php"><li>Customer</li></a>
		<a href="./CManager.php"><li>Customer Manager</li></a>
		<a href="./Devise.php"><li>Devise</li></a>
	</ul>
	<?php
		if(!isset($_COOKIE['UserEmail'])){
			echo '<a class="login" href="./Login.php">Login</a>';
		}else{
			echo '<a class="login" href="./index.php?deconnect=true">'.$_COOKIE['UserEmail'].'</a>';
		}
	?>
</nav>