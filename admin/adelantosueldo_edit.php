<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$amount = $_POST['amount'];
		
		$sql = "UPDATE cashadvance SET amount = '$amount' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Se realizaron los cambios correctamente';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Error complete los datos faltantes';
	}

	header('location:adelantosueldo.php');

?>