<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$description = $_POST['description'];
	$amount = $_POST['amount'];

	$sql = "INSERT INTO bonuses (description, amount) VALUES ('$description', '$amount')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Exito, Bono se creo corretamente';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'No se encontraron datos';
}

header('location: bonos.php');
