
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClientPage</title>
    <link rel="stylesheet" href="client.css">

</head>
<body>
 
 <div class="full-page">
        <div class="navbar">
            <div>
                 <a href=''>
                	<?php session_start();
                    if (!isset($_SESSION['SESSION_EMAIL'])) {
                    header("Location:../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/index.php ");
                    die();
                    }
                    include('./db_connect.php');

                    $query = mysqli_query($conn, "SELECT * FROM roles WHERE email='{$_SESSION['SESSION_EMAIL']}'");

                    if (mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                
                        echo "Welcome back &nbsp". $row['username'] ;
                    }
                      ?>
            </a>
            </div>
            <nav>
                <ul id='MenuItems'>
                    <li><a href='Client.php'>Home</a></li>
                    <li><a href='mydetails.php'>My Details</a></li>
                    <li><a href='loanapplication.php'>Apply For Loan</a></li>
                    <li><a href="../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/logout.php"><button type='button' class='toggle-btn'>Logout</button></a></li>
                </ul>
            </nav>
        </div>
    </div>
  
</body>
</body>
</html>