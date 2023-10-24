<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Update Form</title>
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
                        <h4>Admin Update Form</h4>
                    </div>
                    <div class="card-body">

                        <form action="update2.php" method="POST">

                            <div class="form-group mb-3">
                                <label for="">Loan ID</label>
                                <input type="text" name="loanid" class="form-control" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Loan Amount</label>
                                <input type="text" name="amount" class="form-control" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Purpose</label>
                                <input type="text" name="purpose" class="form-control" >
                            </div>
                            <div class="inputfield">
                                <label>Loan Status</label>
                                   
                                    <select class="input" name="loan_status">
                                    <optgroup label="Loan Status">
				                    <option value = "0">Pending</option>
				                    <option value = "1">Accepted</option>
                                    <option value = "2">Pending Loan</option>
                                    <option value = "3">Completed</option>
                                    <option value = "4">Rejected</option>
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