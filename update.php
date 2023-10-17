<?php
include('./db_connect.php');
if (isset($_POST['update']))
{
    $StaffID =$_GET['ID'];
    $Firstname =$_POST['firstname'];
    $Lastname =$_POST['lastname'];
    $NationalID =$_POST['nationalID'];
    $Phonenumber=$_POST['phonenumber'];
    $Address =$_POST['address'];
    $Email =$_POST['email'];
    $Approvalstatus = $_POST['approval_status'];


    $query3 = "UPDATE staff set firstname = '$Firstname',lastname='$Lastname',nationalID='$NationalID',phonenumber='$Phonenumber',address='$Address',email='$Email',approval_status='$Approvalstatus' where staffID = '$StaffID'";
    $result = mysqli_query($conn,$query3);

    if($result) 
    {
        echo"<br>";
		echo header('location:reports3.php?update=success');
    }
    else
    {
        echo 'Please Check your Query';
    }
}
?>