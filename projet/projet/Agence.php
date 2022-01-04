<?php
	require './config.php';
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}else if(isset($_GET["delete"])){
		$sql = "delete from agence where agence_id=".$_GET["delete"];
		$result = $conn->query($sql);
		header("Location: ./Agence.php");
	}else if(isset($_POST['okAddNew'])){
		$Agence_Code= addslashes($_POST["Agence_code"]);
		$Agence_title= addslashes($_POST["Agence_title"]);
		$Agence_Address= addslashes($_POST["Agence_Address"]);
		$Agence_Phone= addslashes($_POST["Agence_Phone"]);
		$Risque_value= addslashes($_POST["Risque_value"]);

		$imgData = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
        
        $sql = "INSERT INTO agence VALUES(null,$Agence_Code,'$Agence_title','$Agence_Address',$Agence_Phone,$Risque_value,'{$imgData}')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
        
		header("Location: ./Agence.php");
	}else if(isset($_POST["UpdateAgence"])){
		$Agence_Code= addslashes($_POST["Agence_code"]);
		$Agence_title= addslashes($_POST["Agence_title"]);
		$Agence_Address= addslashes($_POST["Agence_Address"]);
		$Agence_Phone= addslashes($_POST["Agence_Phone"]);
		$Risque_value= addslashes($_POST["Risque_value"]);
		if($_FILES['logo']['size']!=0){
			$imgData = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
			$sql = "update agence set company_id=$Agence_Code , agence_title='$Agence_title' , agence_adresse='$Agence_Address' , agence_phone=$Agence_Phone , risque_value=$Risque_value , logo='{$imgData}' where agence_id=".$_GET["update"];
		}else{
			$sql = "update agence set company_id=$Agence_Code , agence_title='$Agence_title' , agence_adresse='$Agence_Address' , agence_phone=$Agence_Phone , risque_value=$Risque_value where agence_id=".$_GET["update"];
		}
        $current_id = mysqli_query($conn, $sql) or header("Location: ./Agence.php?error=false");
        
		header("Location: ./Agence.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Agence</title>
	<link rel="icon" href="./assets/logo.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" type="text/css" href="./style/Agence.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="AgenceContent">
		<?php
			if(isset($_GET['addNew'])){
				?>
					<p class="TitlePage">Add Agence </p>
					<form class="AddContent" method="POST" enctype="multipart/form-data">
						<div class="MyInputs">
							<p class="title">Agence_code :</p>
							<input required="" type="number" name="Agence_code" />
						</div>
						<div class="MyInputs">
							<p class="title">Agence_title :</p>
							<input required="" type="text" name="Agence_title" />
						</div>
						<div class="MyInputs">
							<p class="title">Agence_Address :</p>
							<input required="" type="text" name="Agence_Address"/>
						</div>
						<div class="MyInputs">
							<p class="title">Agence_Phone :</p>
							<input required="" type="text" name="Agence_Phone" />
						</div>
						<div class="MyInputs">
							<p class="title">Risque_Value :</p>
							<input required="" type="number" name="Risque_value" />
						</div>
						<div class="MyInputs">
							<p class="title">Logo :</p>
							<input required="" type="file" name="logo"/>
						</div>
						<br>
						<div class="controls">
							<input type="submit" name="okAddNew" value="OK" class="btn"/>
							<a href="./Agence.php" class="btn">Cancel</a>
						</div>
					</form>
				<?php
			}else if(isset($_GET['update'])){
				$sql = "select * from agence where agence_id=".$_GET['update'];
				$result = $conn->query($sql);
				$row = mysqli_fetch_array($result);
				if ($result->num_rows == 1) {
				  ?>
						<p class="TitlePage">Update Agence </p>
						<form class="AddContent" method="POST" enctype="multipart/form-data">
							<div class="MyInputs">
								<p class="title">Agence_code :</p>
								<input required="" type="number" value="<?php echo $row['company_id']; ?>" name="Agence_code" />
							</div>
							<div class="MyInputs">
								<p class="title">Agence_title :</p>
								<input required="" type="text" value="<?php echo $row['agence_title']; ?>" name="Agence_title" />
							</div>
							<div class="MyInputs">
								<p class="title">Agence_Address :</p>
								<input required="" type="text" value="<?php echo $row['agence_adresse']; ?>" name="Agence_Address"/>
							</div>
							<div class="MyInputs">
								<p class="title">Agence_Phone :</p>
								<input required="" type="text" value="<?php echo $row['agence_phone']; ?>" name="Agence_Phone" />
							</div>
							<div class="MyInputs">
								<p class="title">Risque_value :</p>
								<input required="" type="number" value="<?php echo $row['risque_value']; ?>" name="Risque_value" />
							</div>
							<div class="MyInputs">
								<p class="title">Logo :</p>
								<input type="file" name="logo"/>
								<img src="data:image;base64,<?php echo $row["logo"]; ?>" class="Imglogo" />
							
							</div>
							<div class="controls">
								<input type="submit" value="Modify" class="btn" name="UpdateAgence"/>
								<a href="./Agence.php?delete=<?php echo $row['agence_id'];?>" class="btn">Delete</a>
								<a href="./Agence.php" class="btn">Cancel</a>
							</div>
						</form>
					<?php
				} else {
				  header("Location: ./Agence.php?error=true");
				}
			}else {
		?>
			<p class="TitlePage">Agence </p>
			<?php if(isset($_GET["error"]) && $_GET["error"]=="true") echo '<p class="error">There are some problem, try later</p>';
				if(isset($_GET['search'])){
					$sql = "select * from agence where agence_adresse like '%".$_GET['search']."%' or agence_title like '%".$_GET['search']."%'";
				}else $sql = "select * from agence";
				$result = $conn->query($sql);

			?>
			<div class="Content">
				<div class="header">
					<a href="./Agence.php?addNew" class="AddAgence">Add Agence</a>
					<form class="search" method="GET">
						<input type="text" name="search" placeholder="Seach ..." />
						<button class="submitBTN"><i class="bi bi-search"></i></button>
					</form>
				</div>
				<table class="TableData">
					<tr>
						<th>id</th>
						<th>Agence's company</th>
						<th>Title</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Action</th>
					</tr>
					<?php
						while($row = mysqli_fetch_array($result)){
							?>
								<tr>
									<td><?php echo $row["agence_id"];?></td>
									<td><?php echo $row["company_id"];?></td>
									<td><?php echo $row["agence_title"];?></td>
									<td><?php echo $row["agence_adresse"];?></td>
									<td><?php echo $row["agence_phone"];?></td>
									<td class="action">
										<a href="./Agence.php?update=<?php echo $row['agence_id'];?>">Update</a>
										<a href="./Agence.php?delete=<?php echo $row['agence_id'];?>">Delete</a>
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