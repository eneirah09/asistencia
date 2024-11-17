<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$time_in = $_POST['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "UPDATE schedules SET time_in = '$time_in', time_out = '$time_out' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'El horario se actualizco correctamente';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Error: Complete los campos';
	}

	header('location:horario.php');

?>