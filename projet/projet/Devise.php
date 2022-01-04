<?php
	require './config.php';
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}else if(isset($_GET["delete"])){
		$sql = "delete from devise where devise_id=".$_GET["delete"];
		$result = $conn->query($sql);
		header("Location: ./Devise.php");
	}else if(isset($_POST['okAddNew'])){
		$devise_id= addslashes($_POST["devise_id"]);
		$devise_name= addslashes($_POST["devise_name"]);
        $taux_change= addslashes($_POST["taux_change"]);


		$imgData = base64_encode(file_get_contents($_FILES['logo']));
        
        $sql = "INSERT INTO devise VALUES(null,$devise_id,$devise_name,$taux_change,'{$imgData}')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b>" . mysqli_error($conn));
        
		header("Location: ./Devise.php");
	}else if(isset($_POST["UpdateDevise"])){
		$devise_id= addslashes($_POST["devise_id"]);
		$devise_name= addslashes($_POST["devise_name"]);
        $taux_change= addslashes($_POST["taux_change"]);


		if($_FILES['logo']['size']!=0){
			$imgData = base64_encode(file_get_contents($_FILES['logo']));
			$sql = "update devise set devise_id=$devise_id , devise_name=$devise_name , taux_change=$taux_change, logo='{$imgData}' where id_devise=".$_GET["update"];
		}else{
			$sql = "update devise set devise_id=$devise_id , devise_name=$devise_name , taux_change=$taux_change  where id_devise=".$_GET["update"];
		}
        $current_id = mysqli_query($conn, $sql) or header("Location: ./Devise.php?error=false");
        
		header("Location: ./Devise.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Devise</title>
	<link rel="icon" href="./assets/logo.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" type="text/css" href="./style/Devise.css">
	<script type="text/javascript" src="./scripts/main.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="deviseContent">
		<?php
			if(isset($_GET['addNew'])){
				?>
					<p class="TitlePage">Add Devise : </p>
					<form class="AddContent" method="POST" enctype="multipart/form-data">
						<div class="MyInputs">
							<p class="title">devise_id :</p>
							<input required="" type="number" name="devise_id" />
						</div>
						<div class="MyInputs">
							<p class="title">devise_name :</p>
							<input required="" type="text" name="devise_name" />
						</div>
                        <div class="MyInputs">
							<p class="title">devise_name :</p>
							<input required="" type="number" step="0.001" name="taux_change" />
						</div>
						<div class="MyInputs">
							<p class="title">logo :</p>
							<input required="" type="file" name="logo"/>
						</div>
						<div class="controls">
							<input type="submit" name="okAddNew" value="OK" class="btn"/>
							<a href="./Devise.php" class="btn">Cancel</a>
						</div>
					</form>
				<?php
			}else if(isset($_GET['update'])){
				$sql = "select * from devise where id_devise=".$_GET['update'];
				$result1 = $conn->query($sql);
				$row = mysqli_fetch_array($result1);
				if ($result1->num_rows == 1) {
				  ?>
						<p class="TitlePage">Update Devise  </p>
						<form class="AddContent" method="POST" enctype="multipart/form-data">
							<div class="MyInputs">
								<p class="title">devise_id :</p>
								<input required="" type="number" value="<?php echo $row['devise_id']; ?>" name="devise_id" />
							</div>
							<div class="MyInputs">
								<p class="title">devise_name :</p>
								<input required="" type="text" value="<?php echo $row['devise_name']; ?>" name="devise_name" />
							</div>
                            <div class="MyInputs">
								<p class="title">devise_name :</p>
								<input required="" type="number" step="0.001" value="<?php echo $row['taux_change']; ?>" name="taux_change" />
							</div>
							<div class="MyInputs">
								<p class="title">logo :</p>
								<input type="file" name="logo"/>
								<a class="Imglogo" download="logo.png" href="data:image/png;base64,<?php echo $row["logo"]; ?>" class="Imglogo">Download</a>
							
							</div>
							<div class="controls">
								<input type="submit" value="Modify" class="btn" name="UpdateDevise"/>
								<a href="./Devise.php?delete=<?php echo $row['id_devise'];?>" class="btn">Delete</a>
								<a href="./Devise.php" class="btn">Cancel</a>
							</div>
						</form>
					<?php
				} else {
				  header("Location: ./Devise.php?error=true");
				}
			}else {
		?>
			<p class="TitlePage">Devise  </p>
			<?php if(isset($_GET["error"]) && $_GET["error"]=="true") echo '<p class="error">There are some problem, try later</p>';
				$sql = "select * from devise";
				$result = $conn->query($sql);

			?>
			<div class="Content">
				<div class="header">
					<a href="./Devise.php?addNew" class="Adddevise">Add Devise</a>
					
				</div>
				<table class="TableData">
					<tr>
						<th>id_devise</th>
						<th>devise_name</th>
                        <th>taux_change</th>
						<th>Action</th>
					</tr>
					<?php
						while($row = mysqli_fetch_array($result)){
							?>
								<tr>

									<td><?php echo $row["devise_id"];?></td>
									<td><?php echo $row["devise_name"];?></td>
                                    <td><?php echo $row["taux_change"];?></td>


									<td class="action">
										<a href="./Devise.php?update=<?php echo $row['id_devise'];?>">Update</a>
										<a href="./Devise.php?delete=<?php echo $row['id_devise'];?>">Delete</a>
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