<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomePage</title>
    <link rel="stylesheet" href="Homepage.css">

<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
/*header("location:index.php?page=home");*/
?>
</head>
<body>
 
 <div class="full-page">
        <div class="navbar">
            <div>
                <a href=''>
                    LOAN APPRAISAL</a>
            </div>
            <nav>
                <ul id='MenuItems'>
                    <li><a href='#'>Home</a></li>
                    <li><a href='aboutus.php'>About Us</a></li>
                    <li><a href='#'>Services</a></li>
                    <li><a href='contact us\ContactUs\index.php'>Contact Us</a></li>
                    <li><button class='loginbtn' onclick="document.getElementById('login-form').style.display='block'" style="width:auto;">Login</button></li>
                </ul>
            </nav>
        </div>
        <div id='login-form'class='login-page'>
            <div class="form-box">
                <div class='button-box'>
                    <div id='btn'></div>
                    <a href="../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/index.php">
                    <button type='button' class='toggle-btn'>Log In</button></a>
                    <a href=" ../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/register.php">
                    <button type='button' id="new_borrower" class="toggle-btn"></i> Register</button></a>
        
                </div>
                <form id='login' class='input-group-login'>
                <a> Don't have an account? Register with us Today!</a>
            </form>
            </div>
        </div>
    </div>
  


</body>
</body>
</html>