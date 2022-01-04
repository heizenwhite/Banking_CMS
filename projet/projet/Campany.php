<?php
	require './config.php';
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}else if(isset($_GET["delete"])){
		$sql = "delete from Company where Company_id=".$_GET["delete"];
		$result = $conn->query($sql);
		header("Location: ./Campany.php");
	}else if(isset($_POST['okAddNew'])){
		$Company_email= addslashes($_POST["Company_email"]);
		$Company_name= addslashes($_POST["Company_name"]);
		$Company_Address= addslashes($_POST["Company_Address"]);
		$Company_Phone= addslashes($_POST["Company_Phone"]);
		$Risque_value= addslashes($_POST["Risque_value"]);

		$imgData = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
        
        $sql = "INSERT INTO Company VALUES(null,'$Company_name','$Company_Address','$Company_email',$Company_Phone,$Risque_value,'{$imgData}')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
        
		header("Location: ./Campany.php");
	}else if(isset($_POST["UpdateCompany"])){
		$Company_email= addslashes($_POST["Company_email"]);
		$Company_name= addslashes($_POST["Company_name"]);
		$Company_Address= addslashes($_POST["Company_Address"]);
		$Company_Phone= addslashes($_POST["Company_Phone"]);
		$Risque_value= addslashes($_POST["Risque_value"]);
		if($_FILES['logo']['size']!=0){
			$imgData = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
			$sql = "update Company set company_email='$Company_email' , Company_name='$Company_name' , Company_address='$Company_Address' , Company_phone=$Company_Phone , risque_value=$Risque_value , logo='{$imgData}' where Company_id=".$_GET["update"];
		}else{
			$sql = "update Company set company_email='$Company_email' , Company_name='$Company_name' , Company_address='$Company_Address' , Company_phone=$Company_Phone , risque_value=$Risque_value where Company_id=".$_GET["update"];
		}
        $current_id = mysqli_query($conn, $sql) or header("Location: ./Campany.php?error=false");
        
		header("Location: ./Campany.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Company</title>
	<link rel="icon" href="./assets/logo.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" type="text/css" href="./style/Campany.css">
	<script type="text/javascript" src="./scripts/main.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="CompanyContent">
		<?php
			if(isset($_GET['addNew'])){
				?>
					<p class="TitlePage">Add Company </p>
					<form class="AddContent" method="POST" enctype="multipart/form-data">
						<div class="MyInputs">
							<p class="title">Company_name :</p>
							<input required="" type="text" name="Company_name" />
						</div>
						<div class="MyInputs">
							<p class="title">Company_Address :</p>
							<input required="" type="text" name="Company_Address"/>
						</div>
						<div class="MyInputs">
							<p class="title">Company_Phone :</p>
							<input required="" type="text" name="Company_Phone" />
						</div>
						<div class="MyInputs">
							<p class="title">Company_email :</p>
							<input required="" type="email" name="Company_email" />
						</div>
						<div class="MyInputs">
							<p class="title">Risque_value :</p>
							<input required="" type="number" name="Risque_value" />
						</div>
						<div class="MyInputs">
							<p class="title">Logo :</p>
							<input required="" type="file" name="logo"/>
						</div>
						<div class="controls">
							<input type="submit" name="okAddNew" value="OK" class="btn"/>
							<a href="./Campany.php" class="btn">Cancel</a>
						</div>
					</form>
				<?php
			}else if(isset($_GET['update'])){
				$sql = "select * from Company where Company_id=".$_GET['update'];
				$result = $conn->query($sql);
				$row = mysqli_fetch_array($result);
				if ($result->num_rows == 1) {
				  ?>
						<p class="TitlePage">Update Company </p>
						<form class="AddContent" method="POST" enctype="multipart/form-data">
							<div class="MyInputs">
								<p class="title">Company_name :</p>
								<input required="" type="text" value="<?php echo $row['company_name']; ?>" name="Company_name" />
							</div>
							<div class="MyInputs">
								<p class="title">Company_Address :</p>
								<input required="" type="text" value="<?php echo $row['company_address']; ?>" name="Company_Address"/>
							</div>
							<div class="MyInputs">
								<p class="title">Company_email :</p>
								<input required="" type="email" value="<?php echo $row['company_email']; ?>" name="Company_email" />
							</div>
							<div class="MyInputs">
								<p class="title">Company_Phone :</p>
								<input required="" type="text" value="<?php echo $row['company_phone']; ?>" name="Company_Phone" />
							</div>
							<div class="MyInputs">
								<p class="title">Risque_value :</p>
								<input required="" type="number" value="<?php echo $row['Risque_value']; ?>" name="Risque_value" />
							</div>
							<div class="MyInputs">
								<p class="title">Logo :</p>
								<input type="file" name="logo"/>
								<img src="data:image;base64,<?php echo $row["logo"]; ?>" class="Imglogo" />
							
							</div>
							<div class="controls">
								<input type="submit" value="Modify" class="btn" name="UpdateCompany"/>
								<a href="./Campany.php?delete=<?php echo $row['company_id'];?>" class="btn">Delete</a>
								<a href="./Campany.php" class="btn">Cancel</a>
							</div>
						</form>
					<?php
				} else {
				  header("Location: ./Campany.php?error=true");
				}
			}else {
		?>
			<p class="TitlePage">Company </p>
			<?php if(isset($_GET["error"]) && $_GET["error"]=="true") echo '<p class="error">There are some problem, try later</p>';
				if(isset($_GET['search'])){
					$sql = "select * from Company where Company_address like '%".$_GET['search']."%' or Company_name like '%".$_GET['search']."%'";
				}else $sql = "select * from Company";
				$result = $conn->query($sql);

			?>
			<div class="Content">
				<div class="header">
					<a href="./Campany.php?addNew" class="AddCompany">Add Company</a>
					<form class="search" method="GET">
						<input type="text" name="search" placeholder="Seach ..." />
						<button class="submitBTN"><i class="bi bi-search"></i></button>
					</form>
				</div>
				<table class="TableData">
					<tr>
						<th>id</th>
						<th>Company's name</th>
						<th>Address</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Action</th>
					</tr>
					<?php
						while($row = mysqli_fetch_array($result)){
							?>
								<tr>
									<td><?php echo $row["company_id"];?></td>
									<td><?php echo $row["company_name"];?></td>
									<td><?php echo $row["company_address"];?></td>
									<td><?php echo $row["company_email"];?></td>
									<td><?php echo $row["company_phone"];?></td>
									<td class="action">
										<a href="./Campany.php?update=<?php echo $row['company_id'];?>">Update</a>
										<a href="./Campany.php?delete=<?php echo $row['company_id'];?>">Delete</a>
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