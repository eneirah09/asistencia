<?php
include 'includes/session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];
	$sql = "DELETE FROM schedules WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Se elimino correctamente el horario';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Error: No se ha seleccionado';
}

header('location: horario.php');
