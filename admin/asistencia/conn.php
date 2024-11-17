<?php
	$conn = new mysqli('localhost', 'root', '', 'apsystem');

	if ($conn->connect_error) {
	    die("FALLO LA CONEXION: " . $conn->connect_error);
	}
	
?>