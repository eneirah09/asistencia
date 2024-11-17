<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$employee = $_POST['employee'];
		$amount = $_POST['amount'];
		
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'No se encontro Empleado';
		}
		else{
			$row = $query->fetch_assoc();
			$employee_id = $row['id'];
			$sql = "INSERT INTO cashadvance (employee_id, date_advance, amount) VALUES ('$employee_id', NOW(), '$amount')";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Se agrego correctamente el adelanto de sueldo';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
	}	
	else{
		$_SESSION['error'] = 'Error complete los datos faltantes';
	}

	header('location: adelantosueldo.php');

?>