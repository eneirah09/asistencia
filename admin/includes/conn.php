<?php
$conn = new mysqli('localhost', 'root', '', 'bd_asistencia');

if ($conn->connect_error) {
	die("FALLO CONEXION: " . $conn->connect_error);
}
