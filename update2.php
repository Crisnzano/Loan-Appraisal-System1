<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
$con = mysqli_connect("localhost","root","","loan appraisal system1");

if(isset($_POST['update_stud_data']))
{
    $id = $_POST['loanid'];
    $purpose = $_POST['purpose'];
    $amount = $_POST['amount'];
    $status = $_POST['loan_status'];

    $query = "UPDATE loans SET purpose='$purpose', loan_amount='$amount', loan_status='$status' WHERE loanID='$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Data Updated Successfully";
        header("Location: index.php?page=loans");
    }
    else
    {
        $_SESSION['status'] = "Not Updated";
        header("Location: index.php?page=loans ");
    }
}

?>