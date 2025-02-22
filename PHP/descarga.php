<?php
require('../fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$imagen = '../images/blog/claves.jpeg';
if (!file_exists($imagen)) {
    die("Error: La imagen no existe en la ruta especificada.");
}
$pdf->Image($imagen, 10, 10, 190);
$pdf->Output('D', 'imagen.pdf');
?>
