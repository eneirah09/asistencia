<?php
// /path/to/nomina_sueldo.php

ob_start();
include 'includes/session.php';

function generateRow($from, $to, $conn, $total_deductions) {
    $contents = '';

    $sql = "SELECT employees.lastname, employees.firstname, employees.employee_id, position.rate, 
                   SUM(attendance.num_hr) AS total_hr, 
                   IFNULL(SUM(overtime.hours), 0) AS total_overtime, 
                   attendance.employee_id AS empid 
            FROM attendance 
            LEFT JOIN employees ON employees.id = attendance.employee_id 
            LEFT JOIN position ON position.id = employees.position_id 
            LEFT JOIN overtime ON overtime.employee_id = attendance.employee_id 
                                AND overtime.date_overtime BETWEEN '$from' AND '$to'
            WHERE attendance.date BETWEEN '$from' AND '$to' 
            GROUP BY attendance.employee_id 
            ORDER BY employees.lastname ASC, employees.firstname ASC";

    $query = $conn->query($sql);
    $total = 0;
    while ($row = $query->fetch_assoc()) {
        $empid = $row['empid'];
        $total_hours = $row['total_hr'] + $row['total_overtime'];

        $casql = "SELECT SUM(amount) AS cashamount 
                  FROM cashadvance 
                  WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
        $caquery = $conn->query($casql);
        $carow = $caquery->fetch_assoc();
        $cashadvance = $carow['cashamount'] ?? 0;  // If no cash advance, set to 0

        $gross = $row['rate'] * $total_hours;
        $total_deduction = $total_deductions + $cashadvance;
        $net = $gross - $total_deduction;

        $total += $net;
        $contents .= '
            <tr>
                <td>' . $row['lastname'] . ', ' . $row['firstname'] . '</td>
                <td>' . $row['employee_id'] . '</td>
                <td align="right">' . number_format($net, 2) . '</td>
            </tr>
        ';
    }

    $contents .= '
        <tr>
            <td colspan="2" align="right"><b>Total</b></td>
            <td align="right"><b>' . number_format($total, 2) . '</b></td>
        </tr>
    ';
    return $contents;
}

$range = $_POST['date_range'];
$ex = explode(' - ', $range);
$from = date('Y-m-d', strtotime($ex[0]));
$to = date('Y-m-d', strtotime($ex[1]));

$sql = "SELECT SUM(amount) as total_amount FROM deductions";
$query = $conn->query($sql);
$drow = $query->fetch_assoc();
$total_deductions = $drow['total_amount'];

$from_title = date('M d, Y', strtotime($ex[0]));
$to_title = date('M d, Y', strtotime($ex[1]));

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Nomina: ' . $from_title . ' - ' . $to_title);
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

$content = '';
$content .= '
    <h2 align="center">NOMINA DE SUELDOS</h2>
    <h4 align="center">' . $from_title . " - " . $to_title . '</h4>
    <table border="1" cellspacing="0" cellpadding="3">  
        <tr>  
            <th width="40%" align="center"><b>NOMBRES</b></th>
            <th width="30%" align="center"><b>CÓDIGO</b></th>
            <th width="30%" align="center"><b>SUELDO NETO</b></th> 
        </tr>  
';

$content .= generateRow($from, $to, $conn, $total_deductions);
$content .= '</table>';
$pdf->writeHTML($content);
ob_end_clean();
$pdf->Output('payroll.pdf', 'I');
?>
