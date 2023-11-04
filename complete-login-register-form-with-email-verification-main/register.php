<!-- Code by Brave Coder - https://youtube.com/BraveCoder -->

<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location:../Client.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $uname = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phonenumber']);
        $taxid = mysqli_real_escape_string($conn, $_POST['tax_id']);
        $nationalid = mysqli_real_escape_string($conn, $_POST['nationalID']);
        $type=2;
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        // Validation checks
    if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($address) || empty($phone) || empty($taxid) || empty($nationalid) || empty($_POST['password']) || empty($_POST['confirm-password'])) {
        $msg = "<div class='alert alert-danger'>All fields are required.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "<div class='alert alert-danger'>Invalid email address.</div>";
    } elseif (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM roles WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } elseif ($password !== $confirm_password) {
        $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
    }
    else {

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM roles WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO roles (firstname, lastname, username, email, address, phonenumber, tax_id, password, code, type) VALUES ('{$fname}', '{$lname}', '{$uname}', '{$email}', '{$address}', '{$phone}', '{$taxid}', '{$password}', '{$code}', '{$type}')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $sql2 ="INSERT INTO client (firstname, lastname, username, email, address, phonenumber, tax_id, password, nationalID, type) VALUES ('{$fname}', '{$lname}', '{$uname}', '{$email}', '{$address}', '{$phone}', '{$taxid}', '{$password}', '{$nationalid}', '{$type}')";
                    $result=mysqli_query($conn,$sql2);}

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'crispus.nzano@gmail.com';                     //SMTP username
                        $mail->Password   = 'obnp rsoe eqfn eoed';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('crispus.nzano@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost:81/loan_appraisal_system1/complete-login-register-form-with-email-verification-main/?verification='.$code.'">http://localhost:81/loan_appraisal_system1/complete-login-register-form-with-email-verification-main/?verification='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert alert-info'>We've sent a verification link on your email address.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="firstname" placeholder="Enter Your First Name" value="<?php if (isset($_POST['submit'])) { echo $fname; } ?>" required>
                            <input type="text" class="name" name="lastname" placeholder="Enter Your Last Name" value="<?php if (isset($_POST['submit'])) { echo $lname; } ?>" required>
                            <input type="text" class="name" name="username" placeholder="Enter Your Username" value="<?php if (isset($_POST['submit'])) { echo $uname; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="text" class="name" name="address" placeholder="Enter Your Address" value="<?php if (isset($_POST['submit'])) { echo $address; } ?>" required>
                            <input type="text" class="name" name="phonenumber" placeholder="Enter Your Phone number" value="<?php if (isset($_POST['submit'])) { echo $phone; } ?>" required>
                            <input type="text" class="name" name="tax_id" placeholder="Enter Your Tax ID" value="<?php if (isset($_POST['submit'])) { echo $taxid; } ?>" required>
                            <input type="text" class="name" name="nationalID" placeholder="Enter Your ID number" value="<?php if (isset($_POST['submit'])) { echo $nationalid; } ?>" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>