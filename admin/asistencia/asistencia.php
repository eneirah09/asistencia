<?php
// Verifica si el formulario fue enviado y contiene el campo 'employee'.
if (isset($_POST['employee'])) {
    $output = array('error' => false); // Inicializa un arreglo para manejar la respuesta.
    include 'conn.php'; // Incluye la conexión a la base de datos.
    include 'timezone.php'; // Incluye la configuración de la zona horaria.

    $employee = $_POST['employee']; // Obtiene el código del empleado desde el formulario.
    $status = $_POST['status']; // Obtiene el estado (entrada o salida) desde el formulario.

    // Consulta para verificar si el empleado existe en la base de datos.
    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);
    
    // Si el empleado existe.
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc(); // Obtiene los datos del empleado.
        $id = $row['id']; // Almacena el ID del empleado.
        $date_now = date('Y-m-d'); // Almacena la fecha actual.

        // Si el estado es 'in' (entrada).
        if ($status == 'in') {
            // Verifica si ya se ha registrado la entrada para hoy.
            $sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
            $query = $conn->query($sql);
            if ($query->num_rows > 0) {
                $output['error'] = true;
                $output['message'] = 'Se ha registrado correctamente la entrada de hoy';
            } else {
                // Obtiene el horario del empleado.
                $sched = $row['schedule_id'];
                $lognow = date('H:i:s'); // Almacena la hora actual.
                $sql = "SELECT * FROM schedules WHERE id = '$sched'";
                $squery = $conn->query($sql);
                $srow = $squery->fetch_assoc();
                $logstatus = ($lognow > $srow['time_in']) ? 0 : 1; // Determina si llegó a tiempo o tarde.

                // Inserta un nuevo registro de asistencia.
                $sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', NOW(), '$logstatus')";
                if ($conn->query($sql)) {
                    $output['message'] = 'Llegada: ' . $row['firstname'] . ' ' . $row['lastname'];
                } else {
                    $output['error'] = true;
                    $output['message'] = $conn->error;
                }
            }
        } else {
            // Si el estado es 'out' (salida), verifica si ya se ha registrado la entrada.
            $sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
            $query = $conn->query($sql);
            if ($query->num_rows < 1) {
                $output['error'] = true;
                $output['message'] = 'No se puede registrar la salida sin antes haber registrado la entrada';
            } else {
                $row = $query->fetch_assoc();
                if ($row['time_out'] != '00:00:00') {
                    $output['error'] = true;
                    $output['message'] = 'Se ha registrado correctamente la salida de hoy';
                } else {
                    // Actualiza la hora de salida.
                    $sql = "UPDATE attendance SET time_out = NOW() WHERE id = '" . $row['uid'] . "'";
                    if ($conn->query($sql)) {
                        $output['message'] = 'Salida: ' . $row['firstname'] . ' ' . $row['lastname'];

                        // Calcula las horas trabajadas.
                        $sql = "SELECT * FROM attendance WHERE id = '" . $row['uid'] . "'";
                        $query = $conn->query($sql);
                        $urow = $query->fetch_assoc();
                        $time_in = $urow['time_in'];
                        $time_out = $urow['time_out'];

                        // Obtiene el horario del empleado.
                        $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
                        $query = $conn->query($sql);
                        $srow = $query->fetch_assoc();

                        // Ajusta el tiempo de entrada y salida de acuerdo al horario.
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

                        // Calcula las horas trabajadas.
                        $interval = $actual_time_in->diff($actual_time_out);
                        $hrs = $interval->h;
                        $mins = $interval->i / 60;
                        $int = $hrs + $mins;

                        // Resta 1 hora si trabajó más de 4 horas (por el descanso).
                        if ($int > 4) {
                            $int -= 1;
                        }

                        // Actualiza el registro de asistencia con las horas trabajadas.
                        $sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '" . $row['uid'] . "'";
                        $conn->query($sql);
                    } else {
                        $output['error'] = true;
                        $output['message'] = $conn->error;
                    }
                }
            }
        }
    } else {
        $output['error'] = true;
        $output['message'] = 'No se encontró ningún empleado con ese código';
    }
}

echo json_encode($output); // Devuelve la respuesta en formato JSON.
?>
