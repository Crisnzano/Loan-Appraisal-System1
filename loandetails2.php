<?php 

session_start();
if(isset($_SESSION['name']));

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
                <?php echo "Check your loan details below  ".($_SESSION['role'] == 2 ? " ".$_SESSION['username'] : $_SESSION['username'])."!"  ?>
            </a>
        </div>
        <div><a href="">
            <button type="button" class="btn btn-outline-primary">Download PDF</button></a>
    
            <a href="download.php?ID=<?php echo $row['loan_ID'] ?>"><button type="button" class="btn btn-outline-primary">Download PDF</button></a>
        </div>
        
</div>

<h1 align="center" style="color:deepskyblue;">My loan Details</h1>
<br>
<div class="card-body">
<div class ="table-responsive">
<div class="container-fluid">
<form action=""method="POST">
    <input type="text"name="refnumber"placeholder="Enter Client Reference NO"/>
    <input type="submit"name="search"value="SEARCH BY REFERENCE NO">
</form>
    
<table class="table table-hover">
<thead>
<tr>
  <th scope="col">Loan ID</th>
  <th scope="col">Loan Status</th>
  <th scope="col">Application Date</th>
  <th scope="col">Purpose</th>
  <th scope="col">Loan Amount</th>
  <th scope="col">Monthly repayment amount</th>
  <th scope="col">Reference Number</th>
</tr>
</thead>
<tbody>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include('./db_connect.php');
if(isset($_POST['search']))
{
$refnumber=$_POST['refnumber'];
$query="SELECT l.*, p.monthly_repayment_amount AS pamount  FROM loans l,loan_repayment p where l.loanID = p.loanID AND l.ref_number='$refnumber'";
$connect=mysqli_query($conn,$query);

        while($row= mysqli_fetch_array($connect))

    {
        ?>
        <tr>
        
        <td> <?php echo $row['loanID'];?> </td>
        <td class="text-center">
			<?php if($row['loan_status'] == 0): ?>
			    <span class="badge badge-warning">Pending</span>
			<?php elseif($row['loan_status'] == 1): ?>
				<span class="badge badge-info">Accepted</span>
			<?php elseif($row['loan_status'] == 2): ?>
				<span class="badge badge-primary">Pending Loan</span>
			<?php elseif($row['loan_status'] == 3): ?>
				<span class="badge badge-success">Completed</span>
			<?php elseif($row['loan_status'] == 4): ?>
				<span class="badge badge-danger">Rejected</span>
			<?php endif; ?>
		</td>
        <td> <?php echo $row['application_date'];?> </td>
        <td> <?php echo $row['purpose'];?> </td>
        <td> <?php echo $row['loan_amount'];?> </td>
        <td> <?php echo $row['pamount'];?> </td>
        <td> <?php echo $row['ref_number'];?> </td>
        
      
        </tr>

        <?php

    }


}
?>

</tbody>
</table>
</div>
 <div><a href="Client.php">
            <button type="button" class="btn">Go Back</button></a>
        </div>
</div>
</div>
</body>
</html>