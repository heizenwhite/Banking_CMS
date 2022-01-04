<?php
	require './config.php';
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}else if(isset($_GET["delete"])){
		$sql = "delete from customer_manager where id_card='".$_GET["delete"]."'";
		$result = $conn->query($sql);
		header("Location: ./CManager.php");
	}else if(isset($_POST['okAddNew'])){
		$id_card= addslashes($_POST["id_card"]);
		$email= addslashes($_POST["email"]);
		$CM_phone= addslashes($_POST["CM_phone"]);
		$f_name= addslashes($_POST["f_name"]);
		$l_name= addslashes($_POST["l_name"]);

		$sql = "INSERT INTO customer_manager VALUES('$id_card','$email',$CM_phone,'$f_name','$l_name')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Error :<br/>" . mysqli_error($conn));
        
		header("Location: ./CManager.php");
	}else if(isset($_POST["UpdateCustomer"])){
		$id_card= addslashes($_POST["id_card"]);
		$email= addslashes($_POST["email"]);
		$CM_phone= addslashes($_POST["CM_phone"]);
		$f_name= addslashes($_POST["f_name"]);
		$l_name= addslashes($_POST["l_name"]);
		$sql = "update customer_manager set email='$email' , CM_phone=$CM_phone , f_name='$f_name' , l_name='$l_name' , id_card='$id_card'  where id_card='".$_GET["update"]."'";

        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Error :<br/>" . mysqli_error($conn));
        
		header("Location: ./CManager.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CManager</title>
	<link rel="icon" href="./assets/id_justification.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" type="text/css" href="./style/Customer.css">
	<script type="text/javascript" src="./scripts/main.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="CustomerContent">
		<?php
			if(isset($_GET['addNew'])){
				?>
					<p class="TitlePage">Add Customer Manager </p>
					<form class="AddContent" method="POST" enctype="multipart/form-data">
						<div class="MyInputs">
							<p class="title">id_card :</p>
							<input required="" type="text" name="id_card" />
						</div>
						<div class="MyInputs">
							<p class="title">email :</p>
							<input required="" type="email" name="email" />
						</div>
						<div class="MyInputs">
							<p class="title">CM_phone :</p>
							<input required="" type="number" name="CM_phone" />
						</div>
						<div class="MyInputs">
							<p class="title">f_name :</p>
							<input required="" type="text" name="f_name"/>
						</div>
						<div class="MyInputs">
							<p class="title">l_name :</p>
							<input required="" type="text" name="l_name" />
						</div>
						<div class="controls">
							<input type="submit" name="okAddNew" value="OK" class="btn"/>
							<a href="./CManager.php" class="btn">Cancel</a>
						</div>
					</form>
				<?php
			}else if(isset($_GET['update'])){
				$sql = "select * from customer_manager where id_card='".$_GET['update']."'";
				$result = $conn->query($sql);
				if ($result->num_rows == 1) {
					$row = mysqli_fetch_array($result);
				  ?>
						<p class="TitlePage">Update Customer Manager</p>
						<form class="AddContent" method="POST" enctype="multipart/form-data">
							<div class="MyInputs">
								<p class="title">id_card :</p>
								<input required="" type="text" value="<?php echo $row['id_card']; ?>" name="id_card" />
							</div>
							<div class="MyInputs">
								<p class="title">email :</p>
								<input required="" type="email" value="<?php echo $row['email']; ?>" name="email" />
							</div>
							<div class="MyInputs">
								<p class="title">CM_phone :</p>
								<input required="" type="number" value="<?php echo $row['CM_phone']; ?>" name="CM_phone" />
							</div>
							<div class="MyInputs">
								<p class="title">f_name :</p>
								<input required="" type="text" value="<?php echo $row['f_name']; ?>" name="f_name"/>
							</div>
							<div class="MyInputs">
								<p class="title">l_name :</p>
								<input required="" type="text" value="<?php echo $row['l_name']; ?>" name="l_name" />
							</div>
							<div class="controls">
								<input type="submit" value="Modify" class="btn" name="UpdateCustomer"/>
								<a href="./CManager.php?delete=<?php echo $row['id_card'];?>" class="btn">Delete</a>
								<a href="./CManager.php" class="btn">Cancel</a>
							</div>
						</form>
					<?php
				} else {
				  header("Location: ./CManager.php?error=true");
				}
			}else {
		?>
			<p class="TitlePage">Customer Manager </p>
			<?php if(isset($_GET["error"]) && $_GET["error"]=="true") echo '<p class="error">There are some problem, try later</p>';
				if(isset($_GET['search'])){
					$sql = "select * from customer_manager where email like '%".$_GET['search']."%' or l_name like '%".$_GET['search']."%' or f_name like '%".$_GET['search']."%' or id_card like '%".$_GET['search']."%'";
				}else $sql = "select * from customer_manager";
				$result = $conn->query($sql);

			?>
			<div class="Content">
				<div class="header">
					<a href="./CManager.php?addNew" class="AddCustomer">Add CManager</a>
					<form class="search" method="GET">
						<input type="text" name="search" placeholder="Seach ..." />
						<button class="submitBTN"><i class="bi bi-search"></i></button>
					</form>
				</div>
				<table class="TableData">
					<tr>
						<th>id_card</th>
						<th>First name</th>
						<th>Last Name</th>
						<th>email</th>
						<th>Action</th>
					</tr>
					<?php
						while($row = mysqli_fetch_array($result)){
							?>
								<tr>
									<td><?php echo $row["id_card"];?></td>
									<td><?php echo $row["f_name"];?></td>
									<td><?php echo $row["l_name"];?></td>
									<td><?php echo $row["email"];?></td>
									<td class="action">
										<a href="./CManager.php?update=<?php echo $row['id_card'];?>">Update</a>
										<a href="./CManager.php?delete=<?php echo $row['id_card'];?>">Delete</a>
									</td>
								</tr>
							<?php
						}
					?>
					
				</table>
			</div>
		<?php
			}
		?>
	</content>
</body>
</html>