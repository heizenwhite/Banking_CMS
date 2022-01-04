<?php
	require './config.php';
	if(!isset($_COOKIE['UserEmail'])){
		header("Location: ./Login.php");
	}else if(isset($_GET["delete"])){
		$sql = "delete from transaction where id_transaction=".$_GET["delete"];
		$result = $conn->query($sql);
		header("Location: ./Transactions.php");
	}else if(isset($_POST['okAddNew'])){
		$type_id= addslashes($_POST["type_id"]);
		$provider_id= addslashes($_POST["provider_id"]);
		$id_card= addslashes($_POST["id_card"]);
		$montant= addslashes($_POST["montant"]);

		$imgData = base64_encode(file_get_contents($_FILES['recu']['tmp_name']));
        
        $sql = "INSERT INTO transaction VALUES(null,$type_id,$provider_id,'$id_card',$montant,'{$imgData}')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b>" . mysqli_error($conn));
        
		header("Location: ./Transactions.php");
	}else if(isset($_POST["Updatetransaction"])){
		$type_id= addslashes($_POST["type_id"]);
		$provider_id= addslashes($_POST["provider_id"]);
		$id_card= addslashes($_POST["id_card"]);
		$montant= addslashes($_POST["montant"]);
		if($_FILES['recu']['size']!=0){
			$imgData = base64_encode(file_get_contents($_FILES['recu']['tmp_name']));
			$sql = "update transaction set type_id=$type_id , provider_id=$provider_id , id_card='$id_card' , montant=$montant , recu='{$imgData}' where id_transaction=".$_GET["update"];
		}else{
			$sql = "update transaction set type_id=$type_id , provider_id=$provider_id , id_card='$id_card' , montant=$montant  where id_transaction=".$_GET["update"];
		}
        $current_id = mysqli_query($conn, $sql) or header("Location: ./Transactions.php?error=false");
        
		header("Location: ./Transactions.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Transactions</title>
	<link rel="icon" href="./assets/recu.png">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" type="text/css" href="./style/transaction.css">
	<script type="text/javascript" src="./scripts/main.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php include("./components/navbar.php") ?>
	<content class="transactionContent">
		<?php
			if(isset($_GET['addNew'])){
				?>
					<p class="TitlePage">Add Transaction </p>
					<form class="AddContent" method="POST" enctype="multipart/form-data">
						<div class="MyInputs">
							<p class="title">type_id :</p>
							<input required="" type="number" name="type_id" />
						</div>
						<div class="MyInputs">
							<p class="title">provider_id :</p>
							<input required="" type="number" name="provider_id" />
						</div>
						<div class="MyInputs">
							<p class="title">id_card :</p>
							<input required="" type="text" name="id_card"/>
						</div>
						<div class="MyInputs">
							<p class="title">montant :</p>
							<input required="" type="number" name="montant" />
						</div>
						<div class="MyInputs">
							<p class="title">recu :</p>
							<input required="" type="file" name="recu"/>
						</div>
						<div class="controls">
							<input type="submit" name="okAddNew" value="OK" class="btn"/>
							<a href="./Transactions.php" class="btn">Cancel</a>
						</div>
					</form>
				<?php
			}else if(isset($_GET['update'])){
				$sql = "select * from transaction where id_transaction=".$_GET['update'];
				$result = $conn->query($sql);
				$row = mysqli_fetch_array($result);
				if ($result->num_rows == 1) {
				  ?>
						<p class="TitlePage">Update Transaction </p>
						<form class="AddContent" method="POST" enctype="multipart/form-data">
							<div class="MyInputs">
								<p class="title">type_id :</p>
								<input required="" type="number" value="<?php echo $row['type_id']; ?>" name="type_id" />
							</div>
							<div class="MyInputs">
								<p class="title">provider_id :</p>
								<input required="" type="number" value="<?php echo $row['provider_id']; ?>" name="provider_id" />
							</div>
							<div class="MyInputs">
								<p class="title">id_card :</p>
								<input required="" type="text" value="<?php echo $row['id_card']; ?>" name="id_card"/>
							</div>
							<div class="MyInputs">
								<p class="title">montant :</p>
								<input required="" type="number" value="<?php echo $row['montant']; ?>" name="montant" />
							</div>
							<div class="MyInputs">
								<p class="title">recu :</p>
								<input type="file" name="recu"/>
								<a class="Imglogo" download="recu.png" href="data:image/png;base64,<?php echo $row["recu"]; ?>" class="Imgrecu">Download</a>
							
							</div>
							<div class="controls">
								<input type="submit" value="Modify" class="btn" name="Updatetransaction"/>
								<a href="./Transactions.php?delete=<?php echo $row['id_transaction'];?>" class="btn">Delete</a>
								<a href="./Transactions.php" class="btn">Cancel</a>
							</div>
						</form>
					<?php
				} else {
				  header("Location: ./Transactions.php?error=true");
				}
			}else {
		?>
			<p class="TitlePage">Transactions </p>
			<?php if(isset($_GET["error"]) && $_GET["error"]=="true") echo '<p class="error">There are some problem, try later</p>';
				$sql = "select * from transaction";
				$result = $conn->query($sql);

			?>
			<div class="Content">
				<div class="header">
					<a href="./Transactions.php?addNew" class="Addtransaction">Add Transaction</a>
					
				</div>
				<table class="TableData">
					<tr>
						<th>id_transaction</th>
						<th>type_id</th>
						<th>provider_id</th>
						<th>id_card</th>
						<th>montant</th>
						<th>Action</th>
					</tr>
					<?php
						while($row = mysqli_fetch_array($result)){
							?>
								<tr>
									<td><?php echo $row["id_transaction"];?></td>
									<td><?php echo $row["type_id"];?></td>
									<td><?php echo $row["provider_id"];?></td>
									<td><?php echo $row["id_card"];?></td>
									<td><?php echo $row["montant"];?>Dhs</td>
									<td class="action">
										<a href="./Transactions.php?update=<?php echo $row['id_transaction'];?>">Update</a>
										<a href="./Transactions.php?delete=<?php echo $row['id_transaction'];?>">Delete</a>
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