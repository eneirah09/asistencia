<?php
ob_start();
include 'includes/session.php';

function generateRow($conn)
{
    $contents = '';

    $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id";

    $query = $conn->query($sql);
    $total = 0;
    while ($row = $query->fetch_assoc()) {
        $contents .= "
			<tr>
				<td>" . $row['lastname'] . ", " . $row['firstname'] . "</td>
				<td>" . $row['employee_id'] . "</td>
				<td>" . date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])) . "</td>
			</tr>
			";
    }

    return $contents;
}

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Horario Empleados');
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

$content = '';
$content .= '
 <h2 align="center">MUNICIPALIDAD DISTRITAL DE PACAIPAMPA</h2>
      	<h2 align="center">HORARIO PERSONAL</h2>
      	<h3 align="center"></h3>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
           		<th width="40%" align="center" bgcolor="#EDE7F6"><b>NOMBRE</b></th>
                <th width="30%" align="center" bgcolor="#EDE7F6"><b>CÓDIGO</b></th>
				<th width="30%" align="center" bgcolor="#EDE7F6"><b>HORARIO</b></th> 
           </tr>  
      ';
$content .= generateRow($conn);
$content .= '</table>';
$pdf->writeHTML($content);
ob_end_clean();
$pdf->Output('schedule.pdf', 'I');
