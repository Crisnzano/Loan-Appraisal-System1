<?php

include('db_connect.php');
$sql = "SELECT * FROM loans";

$records = mysqli_query($conn,$sql);

require("library/fpdf.php"); 

$pdf = new FPDF('p','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B', 8);

$pdf->cell(15, 10, "LoanID", 1, 0, 'C');
$pdf->cell(15, 10, "clientID", 1, 0, 'C');
$pdf->cell(20, 10, "Loan Status", 1, 0, 'C');
$pdf->cell(36, 10, "Purpose", 1, 0, 'C');
$pdf->cell(25, 10, "Loan Amount", 1, 0, 'C');
$pdf->cell(15, 10, "Plan ID", 1, 0, 'C');
$pdf->cell(40, 10, "Date Released", 1, 0, 'C');
$pdf->cell(27, 10, "Reference Number", 1, 1, 'C');


$pdf->SetFont('Arial','',8);

while($row=mysqli_fetch_array($records))
{
    $pdf->cell(15, 10, $row['loanID'], 1, 0, 'C');
    $pdf->cell(15, 10, $row['clientID'], 1, 0, 'C');
    $pdf->cell(20, 10, $row['loan_status'], 1, 0, 'C');
    $pdf->cell(36, 10, $row['purpose'], 1, 0, 'C');
    $pdf->cell(25, 10, $row['loan_amount'], 1, 0, 'C');
    $pdf->cell(15, 10, $row['planID'], 1, 0, 'C');
    $pdf->cell(40, 10, $row['date_released'], 1, 0, 'C');
    $pdf->cell(27, 10, $row['ref_number'], 1, 1, 'C');
    
}
$pdf->Output();

?>