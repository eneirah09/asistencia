<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $employee_id = $_POST['employee_id'];
    $date = $_POST['date'];
    $absence_type_id = $_POST['absence_type_id'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO absences (employee_id, date, absence_type_id, reason) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("isis", $employee_id, $date, $absence_type_id, $reason);
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Inasistencia agregada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al agregar inasistencia: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Error al preparar la consulta: ' . $conn->error;
    }
} else {
    $_SESSION['error'] = 'Rellene el formulario de adición primero';
}

header('location: inasistencias.php');
