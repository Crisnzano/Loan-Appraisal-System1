<?php 
    include('./db_connect.php');

    session_start();
    if(isset($_SESSION['name']));
                                              
    $query="SELECT * FROM staff ";
    $result=mysqli_query($conn,$query);

    ?>
  <!DOCTYPE html>
<html>
<head>
    <title>
        
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="mydetails.css">

</head>
<body>
<div class="full-page">
<div class="navbar">
            <div>
                <a href=''>
                    <?php echo "Check details below  ".($_SESSION['role'] == 2 ? " ".$_SESSION['username'] : $_SESSION['username'])."!"  ?>
                </a>
            </div>
            <div><a href="reports2.php">
                <button type="button" class="btn btn-outline-primary">Loan Details</button></a>
                <a href="generatePdf.php">
                <button type="button" class="btn btn-outline-primary">Download PDF</button></a>
            </div>
            

            
</div>

<h1 align="center" style="color:deepskyblue;">Staff Details</h1>
<br>
<div class="card-body">
    <div class ="table-responsive">
        
<table class="table table-hover">  
    <thead>
    <tr>
        <td>Staff ID</td>
        <td>Firtsname</td>
        <td>LastName</td>
        <td>Rolename</td>
        <td>NationalID</td>
        <td>Phonenumber</td>
        <td>Email</td>
        <td>Address</td>
        <td>TaxID</td>
        <td>Approval Status</td>
        <td>Edit</td>
        <td>Delete</td>

    </tr>
    </thead>
    <tbody>
    <?php

    while($row=mysqli_fetch_assoc($result))
    {
        $StaffID =$row['staffID'];
        $Firstname =$row['firstname'];
        $Lastname =$row['lastname'];
        $Rolename =$row['role_name'];
        $NationalID =$row['nationalID'];
        $Phonenumber=$row['phonenumber'];
        $Email =$row['email'];
        $Address =$row['address'];
        $TaxID =$row['tax_id'];
        $Approvalstatus=$row['approval_status'];

?>
<tr>
        <td><?php echo $StaffID ?></td>
        <td><?php echo $Firstname ?></td>
        <td><?php echo $Lastname ?></td>
        <td><?php echo $Rolename ?></td>
        <td><?php echo $NationalID ?></td>
        <td><?php echo $Phonenumber ?></td>
        <td><?php echo $Email ?></td>
        <td><?php echo $Address ?></td>
        <td><?php echo $TaxID ?></td>
        <td class="text-center">
			<?php if($row['approval_status'] == 1): ?>
			    <span class="badge badge-warning">Accepted</span>
			<?php elseif($row['approval_status'] == 2): ?>
				<span class="badge badge-info">Rejected</span>
			<?php endif; ?>
		</td>

        <td><a href="edit.php?GetID=<?php echo $StaffID ?>">Edit</a></td>
        <td><a href="delete.php?Del=<?php echo $StaffID ?>">Delete</a></td>
</tr>
<?php
    }
    ?>
    </tbody>
</table>
    </div>
    <div><a href="Manager.php">
                <button type="button" class="btn btn-outline-primary">Go Back</button></a>
            </div>
    