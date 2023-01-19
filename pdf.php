<?php
require('fpdf/fpdf.php');
require('misbitacoras.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,$nombre);
$route = "upload/".$rd['mail']."/";
$pdf->Output($route.'file.pdf', 'f');

header('location:'.$route.'file.pdf');
?>