<?php
include 'includes/session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM absences WHERE id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Inasistencia eliminada exitosamente';
    } else {
        $_SESSION['error'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Seleccione la inasistencia para eliminar primero';
}

header('location: inasistencias.php');
