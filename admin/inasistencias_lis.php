<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);  // Asegurarse de que el ID sea un entero

    $stmt = $conn->prepare("SELECT absences.*, employees.firstname, employees.lastname, absence_types.description AS absence_type, 
                                   (SELECT COUNT(*) FROM absences WHERE employee_id = employees.id) AS absence_days 
                            FROM absences 
                            LEFT JOIN employees ON employees.id = absences.employee_id 
                            LEFT JOIN absence_types ON absence_types.id = absences.absence_type_id
                            WHERE absences.id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>
