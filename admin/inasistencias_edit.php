<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $absence_type_id = $_POST['absence_type_id'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("UPDATE absences SET date = ?, absence_type_id = ?, reason = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sisi", $date, $absence_type_id, $reason, $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Inasistencia actualizada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar inasistencia: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Error al preparar la consulta: ' . $conn->error;
    }
} else {
    $_SESSION['error'] = 'Seleccione la inasistencia para editar primero';
}

header('location: inasistencias.php');
