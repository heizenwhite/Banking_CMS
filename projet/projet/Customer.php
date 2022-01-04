<?php
	require './config.php';
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}else if(isset($_GET["delete"])){
		$sql = "delete from Customer where id_customer=".$_GET["delete"];
		$result = $conn->query($sql);
		header("Location: ./Customer.php");
	}else if(isset($_POST['okAddNew'])){
		$first_name= addslashes($_POST["first_name"]);
		$last_name= addslashes($_POST["last_name"]);
		$customer_GSM= addslashes($_POST["customer_GSM"]);
		$id_c_type= addslashes($_POST["id_c_type"]);

		$imgData = base64_encode(file_get_contents($_FILES['id_justification']['tmp_name']));
        
        $sql = "INSERT INTO Customer VALUES(null,$id_c_type,'$first_name','$last_name',$customer_GSM,'{$imgData}')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
        
		header("Location: ./Customer.php");
	}else if(isset($_POST["UpdateCustomer"])){
		$first_name= addslashes($_POST["first_name"]);
		$last_name= addslashes($_POST["last_name"]);
		$customer_GSM= addslashes($_POST["customer_GSM"]);
		$id_c_type= addslashes($_POST["id_c_type"]);
		if($_FILES['id_justification']['size']!=0){
			$imgData = base64_encode(file_get_contents($_FILES['id_justification']['tmp_name']));
			$sql = "update Customer set first_name='$first_name' , last_name='$last_name' , customer_GSM='$customer_GSM' , id_c_type=$id_c_type , id_justification='{$imgData}' where id_customer=".$_GET["update"];
		}else{
			$sql = "update Customer set first_name='$first_name' , last_name='$last_name' , customer_GSM='$customer_GSM' , id_c_type=$id_c_type  where id_customer=".$_GET["update"];
		}
        $current_id = mysqli_query($conn, $sql) or header("Location: ./Customer.php?error=false");
        
		header("Location: ./Customer.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Customer</title>
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
					<p class="TitlePage">Add Customer</p>
					<form class="AddContent" method="POST" enctype="multipart/form-data">
						<div class="MyInputs">
							<p class="title">first_name :</p>
							<input required="" type="text" name="first_name" />
						</div>
						<div class="MyInputs">
							<p class="title">last_name :</p>
							<input required="" type="text" name="last_name" />
						</div>
						<div class="MyInputs">
							<p class="title">customer_GSM :</p>
							<input required="" type="number" name="customer_GSM"/>
						</div>
						<div class="MyInputs">
							<p class="title">id_c_type :</p>
							<input required="" type="number" name="id_c_type" />
						</div>
						<div class="MyInputs">
							<p class="title">id_justification :</p>
							<input required="" type="file" name="id_justification"/>
						</div>
						<div class="controls">
							<input type="submit" name="okAddNew" value="OK" class="btn"/>
							<a href="./Customer.php" class="btn">Cancel</a>
						</div>
					</form>
				<?php
			}else if(isset($_GET['update'])){
				$sql = "select * from Customer where id_customer=".$_GET['update'];
				$result = $conn->query($sql);
				$row = mysqli_fetch_array($result);
				if ($result->num_rows == 1) {
				  ?>
						<p class="TitlePage">Update Customer</p>
						<form class="AddContent" method="POST" enctype="multipart/form-data">
							<div class="MyInputs">
								<p class="title">first_name :</p>
								<input required="" type="text" value="<?php echo $row['first_name']; ?>" name="first_name" />
							</div>
							<div class="MyInputs">
								<p class="title">last_name :</p>
								<input required="" type="text" value="<?php echo $row['last_name']; ?>" name="last_name" />
							</div>
							<div class="MyInputs">
								<p class="title">customer_GSM :</p>
								<input required="" type="number" value="<?php echo $row['customer_GSM']; ?>" name="customer_GSM"/>
							</div>
							<div class="MyInputs">
								<p class="title">id_c_type :</p>
								<input required="" type="number" value="<?php echo $row['id_c_type']; ?>" name="id_c_type" />
							</div>
							<div class="MyInputs">
								<p class="title">id_justification :</p>
								<input type="file" name="id_justification"/>
								<img class="Imglogo" src="data:image;base64,<?php echo $row["id_justification"]; ?>" class="Imgid_justification"/>
							
							</div>
							<div class="controls">
								<input type="submit" value="Modify" class="btn" name="UpdateCustomer"/>
								<a href="./Customer.php?delete=<?php echo $row['id_customer'];?>" class="btn">Delete</a>
								<a href="./Customer.php" class="btn">Cancel</a>
							</div>
						</form>
					<?php
				} else {
				  header("Location: ./Customer.php?error=true");
				}
			}else {
		?>
			<p class="TitlePage">Customer</p>
			<?php if(isset($_GET["error"]) && $_GET["error"]=="true") echo '<p class="error">There are some problem, try later</p>';
				if(isset($_GET['search'])){
					$sql = "select * from Customer where first_name like '%".$_GET['search']."%' or last_name like '%".$_GET['search']."%'";
				}else $sql = "select * from Customer";
				$result = $conn->query($sql);

			?>
			<div class="Content">
				<div class="header">
					<a href="./Customer.php?addNew" class="AddCustomer">Add Customer</a>
					<form class="search" method="GET">
						<input type="text" name="search" placeholder="Seach ..." />
						<button class="submitBTN"><i class="bi bi-search"></i></button>
					</form>
				</div>
				<table class="TableData">
					<tr>
						<th>id</th>
						<th>First name</th>
						<th>Last Name</th>
						<th>Customer_GSM</th>
						<th>Customer_type</th>
						<th>Action</th>
					</tr>
					<?php
						while($row = mysqli_fetch_array($result)){
							?>
								<tr>
									<td><?php echo $row["id_customer"];?></td>
									<td><?php echo $row["first_name"];?></td>
									<td><?php echo $row["last_name"];?></td>
									<td><?php echo $row["customer_GSM"];?></td>
									<td><?php echo $row["id_c_type"];?></td>
									<td class="action">
										<a href="./Customer.php?update=<?php echo $row['id_customer'];?>">Update</a>
										<a href="./Customer.php?delete=<?php echo $row['id_customer'];?>">Delete</a>
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