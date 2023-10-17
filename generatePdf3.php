<?php

include('db_connect.php');
$sql = "SELECT * FROM roles";

$records = mysqli_query($conn,$sql);

require("library/fpdf.php"); 

$pdf = new FPDF('p','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B', 8);

$pdf->cell(15, 10, "RoleID", 1, 0, 'C');
$pdf->cell(20, 10, "Rolename", 1, 0, 'C');
$pdf->cell(20, 10, "Username", 1, 0, 'C');
$pdf->cell(20, 10, "Firstname", 1, 0, 'C');
$pdf->cell(16, 10, "Lastname", 1, 0, 'C');
$pdf->cell(15, 10, "PhoneNo", 1, 0, 'C');
$pdf->cell(39, 10, "Email", 1, 0, 'C');
$pdf->cell(23, 10, "Address", 1, 0, 'C');
$pdf->cell(25, 10, "Tax ID", 1, 1, 'C');


$pdf->SetFont('Arial','',8);

while($row=mysqli_fetch_array($records))
{
    $pdf->cell(15, 10, $row['roleID'], 1, 0, 'C');
    $pdf->cell(20, 10, $row['role_name'], 1, 0, 'C');
    $pdf->cell(20, 10, $row['username'], 1, 0, 'C');
    $pdf->cell(20, 10, $row['firstname'], 1, 0, 'C');
    $pdf->cell(16, 10, $row['lastname'], 1, 0, 'C');
    $pdf->cell(15, 10, $row['phonenumber'], 1, 0, 'C');
    $pdf->cell(39, 10, $row['email'], 1, 0, 'C');
    $pdf->cell(23, 10, $row['address'], 1, 0, 'C');
    $pdf->cell(25, 10, $row['tax_id'], 1, 1, 'C');
    
}
$pdf->Output();

?>