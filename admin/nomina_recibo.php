<?php
ob_start();
include 'includes/session.php';

$range = $_POST['date_range'];
$ex = explode(' - ', $range);
$from = date('Y-m-d', strtotime($ex[0]));
$to = date('Y-m-d', strtotime($ex[1]));

// Obtener deducciones
$sql = "SELECT * FROM deductions";
$query = $conn->query($sql);
$deductions = [];
while ($drow = $query->fetch_assoc()) {
    $deductions[] = $drow;
}

// Obtener bonos
$sql = "SELECT * FROM bonuses";
$query = $conn->query($sql);
$bonuses = [];
while ($brow = $query->fetch_assoc()) {
    $bonuses[] = $brow;
}

$from_title = date('M d, Y', strtotime($ex[0]));
$to_title = date('M d, Y', strtotime($ex[1]));

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Recibo: ' . $from_title . ' - ' . $to_title);
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();

// Añadir logo
$logo = '../images/images.png'; // Reemplaza con la ruta correcta de tu logo
$pdf->Image($logo, 10, 10, 20, 20); // Ajusta las posiciones y tamaño según tu necesidad
$pdf->Ln(5); // Salto de línea para dar espacio después del logo

$contents = '';

$sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, employees.employee_id AS employee 
        FROM attendance 
        LEFT JOIN employees ON employees.id=attendance.employee_id 
        LEFT JOIN position ON position.id=employees.position_id 
        WHERE date BETWEEN '$from' AND '$to' 
        GROUP BY attendance.employee_id 
        ORDER BY employees.lastname ASC, employees.firstname ASC";

$query = $conn->query($sql);
while ($row = $query->fetch_assoc()) {
    $empid = $row['empid'];
    $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
    $caquery = $conn->query($casql);
    $carow = $caquery->fetch_assoc();
    $cashadvance = $carow['cashamount'];

    $gross = $row['rate'] * $row['total_hr'];
    $bonus_total = 0;
    $bonus_details = '';

    // Sumar bonos al salario bruto
    foreach ($bonuses as $bonus) {
        $bonus_total += $bonus['amount'];
        $bonus_details .= '<tr> 
                <td width="50%" align="left">' . $bonus['description'] . '</td>
                <td width="50%" align="right">' . number_format($bonus['amount'], 2) . '</td> 
            </tr>';
    }

    $gross += $bonus_total;
    $total_deduction = 0;
    $deduction_details = '';

    // Sumar deducciones
    foreach ($deductions as $deduction) {
        $total_deduction += $deduction['amount'];
        $deduction_details .= '<tr> 
                <td width="50%" align="left">' . $deduction['description'] . '</td>
                <td width="50%" align="right">' . number_format($deduction['amount'], 2) . '</td> 
            </tr>';
    }

    $total_deduction += $cashadvance;
    $net = $gross - $total_deduction;

    $contents .= '
        <h2 align="center">MUNICIPALIDAD DISTRITAL DE PACAIPAMPA</h2>
        <h4 align="center">' . $from_title . " - " . $to_title . '</h4>
        <table cellspacing="0" cellpadding="3" border="1">  
             <tr>  
                 <td width="25%" align="left" bgcolor="#D1C4E9"> <b>NOMBRE Y APELLIDOS </b></td>
                 <td width="25%">' . strtoupper($row['firstname'] . " " . $row['lastname']) . '</td>
                 <td width="25%" align="left" bgcolor="#D1C4E9"><b> CÓDIGO </b></td>
                 <td width="25%">' . $row['employee'] . '</td>   
            </tr>
            <tr>
                <td width="25%" align="left" bgcolor="#D1C4E9"><b>TOTAL DE HORAS  </b></td>
                <td width="25%" align="right">' . number_format($row['total_hr'], 2) . '</td>
                <td width="25%" align="left" bgcolor="#D1C4E9"><b>SUELDO BRUTO </b></td>
                <td width="25%" align="right">' . number_format(($row['rate'] * $row['total_hr']), 2) . '</td> 
            </tr>';

    if (!empty($bonus_details)) {
        $contents .= '
            <tr> 
                <td colspan="4" align="center" bgcolor="#D1C4E9"><b>BONOS</b></td>
            </tr>
            ' . $bonus_details . '
            <tr> 
                <td width="50%" align="left" bgcolor="#EDE7F6"><b>TOTAL DE BONOS</b></td>
                <td width="50%" align="right" bgcolor="#EDE7F6"><b>' . number_format($bonus_total, 2) . '</b></td> 
            </tr>';
    }

    if (!empty($deduction_details)) {
        $contents .= '
            <tr> 
                <td colspan="2" align="center" bgcolor="#D1C4E9"><b>DESCUENTOS</b></td>
            </tr>
            ' . $deduction_details;
    }

    $contents .= '
            <tr> 
                <td width="50%" align="left" >ADELANTO DE SUELDO </td>
                <td width="50%" align="right">' . number_format($cashadvance, 2) . '</td> 
            </tr>
            <tr> 
                <td width="50%" align="left" bgcolor="#EDE7F6"><b>TOTAL DEDUCCIONES</b></td>
                <td width="50%" align="right" bgcolor="#EDE7F6"><b>' . number_format($total_deduction, 2) . '</b></td> 
            </tr>
            <tr> 
                <td width="50%" align="left" bgcolor="#D1C4E9"><b>SUELDO NETO</b></td>
                <td width="50%" align="right" bgcolor="#D1C4E9"><b>' . number_format($net, 2) . '</b></td> 
            </tr>
        </table>
        <br><hr>';
}

$pdf->writeHTML($contents);
ob_end_clean();
$pdf->Output('payslip.pdf', 'I');
?>
