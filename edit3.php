<?php session_start(); 
include('db_connect.php');
$LoanID= $_GET['GetID'];
$query = " SELECT l.*, p.monthly_repayment_amount AS pamount, p.payee AS payee FROM loans l,loan_repayment p where l.loan_ID = p.loanID AND l.loan_ID = '".$LoanID."'";
$result = mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result)) 
{
    $LoanID =$row['loan_ID'];
    $Payee =$row['payee'];
    $Applicationdate =$row['application_date'];
    $Purpose =$row['purpose'];
    $Loanamount =$row['loan_amount'];
    $Loanstatus =$row['loan_status'];

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client.php</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                ?>

                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Update Client Data Form</h4>
                    </div>
                    <div class="card-body">

                        <form action="update2.php?ID =<?php echo $loanID ?>" method="POST">

                            <div class="form-group mb-3">
                                <label for="">Client Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $Payee ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Purpose</label>
                                <input type="text" name="purpose" class="form-control" value="<?php echo $Purpose ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Loan Amount</label>
                                <input type="text" name="class" class="form-control" value="<?php echo $Loanamount ?>">
                            </div>
                            <div class="inputfield">
                                <label>Loan Status</label>
                                    <?php 
                                    $query = "SELECT loan_status FROM  loans ";
                                    $result = mysqli_query($conn,$query);
                                     ?>

          
                                    <select id ="" class="input" name="loan_status" value="<?php echo $Loanstatus ?>">
                                    <optgroup label="Loan Status">
                                	<?php while($row = mysqli_fetch_array($result)) ?>
				                    <option value="0" <?php echo isset($meta['loan_status']) && $meta['loan_status'] == 0 ? 'selected': '' ?>>Pending</option>
				                    <option value="1" <?php echo isset($meta['loan_status']) && $meta['loan_status'] == 1 ? 'selected': '' ?>>Accepted</option>
                                    <option value="2" <?php echo isset($meta['loan_status']) && $meta['loan_status'] == 2 ? 'selected': '' ?>>Pending Loan</option>
                                    <option value="3" <?php echo isset($meta['loan_status']) && $meta['loan_status'] == 3 ? 'selected': '' ?>>Completed</option>
                                    <option value="4" <?php echo isset($meta['loan_status']) && $meta['loan_status'] == 4 ? 'selected': '' ?>>Rejected</option>
                                    </optgroup>
                                    </select>
                                    </div> 
                            <div class="form-group mb-3">
                                <button type="submit" name="update_stud_data" class="btn btn-primary">Update Data</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


