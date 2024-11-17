<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$employee = $_POST['employee'];
	$date = $_POST['date'];
	$time_in = $_POST['time_in'];
	$time_out = $_POST['time_out'];

	// Convertir los tiempos de entrada y salida a formato 24 horas
	$time_in = date('H:i:s', strtotime($time_in));
	$time_out = date('H:i:s', strtotime($time_out));

	// Validar si el empleado existe
	$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
	$query = $conn->query($sql);
	if ($query->num_rows < 1) {
		$_SESSION['error'] = 'Empleado no encontrado';
		header('location: asistencia.php');
		exit();
	} else {
		$row = $query->fetch_assoc();
		$emp = $row['id'];

		// Validar si ya existe una asistencia para la fecha dada
		$sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
		$query = $conn->query($sql);
		if ($query->num_rows > 0) {
			$_SESSION['error'] = 'La asistencia del empleado ya existe';
			header('location: asistencia.php');
			exit();
		} else {
			// Obtener horario del empleado
			$sched = $row['schedule_id'];
			$sql = "SELECT * FROM schedules WHERE id = '$sched'";
			$squery = $conn->query($sql);
			$scherow = $squery->fetch_assoc();
			$logstatus = ($time_in > $scherow['time_in']) ? 0 : 1;

			// Insertar nueva asistencia
			$sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, status) VALUES ('$emp', '$date', '$time_in', '$time_out', '$logstatus')";
			if ($conn->query($sql)) {
				$_SESSION['success'] = 'Asistencia agregada exitosamente';
				$id = $conn->insert_id;

				// Obtener el horario del empleado
				$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$emp'";
				$query = $conn->query($sql);
				$srow = $query->fetch_assoc();

				// Ajustar tiempo de entrada y salida de acuerdo al horario
				$scheduled_time_in = new DateTime($srow['time_in']);
				$scheduled_time_out = new DateTime($srow['time_out']);
				$actual_time_in = new DateTime($time_in);
				$actual_time_out = new DateTime($time_out);

				if ($scheduled_time_in > $actual_time_in) {
					$actual_time_in = $scheduled_time_in;
				}
				if ($scheduled_time_out < $actual_time_out) {
					$actual_time_out = $scheduled_time_out;
				}

				// Calcular las horas trabajadas
				$interval = $actual_time_in->diff($actual_time_out);
				$hrs = $interval->h;
				$mins = $interval->i / 60;
				$int = $hrs + $mins;

				// Restar 1 hora si trabajó más de 4 horas (por el descanso)
				if ($int > 4) {
					$int -= 1;
				}

				// Actualizar el registro de asistencia con las horas trabajadas
				$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '$id'";
				$conn->query($sql);
			} else {
				$_SESSION['error'] = $conn->error;
			}
		}
	}
} else {
	$_SESSION['error'] = 'Complete el formulario de adición primero';
}

header('location: asistencia.php');
exit();
