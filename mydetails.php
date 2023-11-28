<?php

require_once '../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/vendor/autoload.php'; // Include Composer's autoloader
require_once '../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/vendor/tecnickcom/tcpdf/tcpdf.php'; // Include TCPDF

// Function to generate the PDF report
function generatePDF($data) {
    // Create a new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Client Details');
    $pdf->SetSubject('Client Details');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('dejavusans', '', 12);

    // Output personal details and roles data to the PDF
    $content = 'Client ID: ' . $data['roleID'] . "\n";
    $content .= 'Username: ' . $data['username'] . "\n";
    $content .= 'Firstname: ' . $data['firstname'] . "\n";
    $content .= 'Lastname: ' . $data['lastname'] . "\n";
    $content .= 'Phonenumber: ' . $data['phonenumber'] . "\n";
    $content .= 'Email: ' . $data['email'] . "\n";
    $content .= 'Address: ' . $data['address'] . "\n";
    $content .= 'Tax ID: ' . $data['tax_id'] . "\n";

    $pdf->MultiCell(0, 10, $content);

    // Output the PDF as a download
    $pdf->Output('client_details.pdf', 'D');
}

session_start();
if (isset($_SESSION['name'])) {
    include('./db_connect.php'); // Include your database connection code

    if (isset($_POST['search'])) {
        $email = $_POST['email'];
        $query = "SELECT * FROM roles WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_array($result)) {
            // Display details as HTML
            echo '<div>';
            echo '<h2>Client Details</h2>';
            echo '<p>Client ID: ' . $row['roleID'] . '</p>';
            echo '<p>Username: ' . $row['username'] . '</p>';
            echo '<p>Firstname: ' . $row['firstname'] . '</p>';
            echo '<p>Lastname: ' . $row['lastname'] . '</p>';
            echo '<p>Phonenumber: ' . $row['phonenumber'] . '</p>';
            echo '<p>Email: ' . $row['email'] . '</p>';
            echo '<p>Address: ' . $row['address'] . '</p>';
            echo '<p>Tax ID: ' . $row['tax_id'] . '</p>';
            echo '</div>';
        }
    }

    if (isset($_POST['download_pdf'])) {
        $email = $_POST['email'];
        $query = "SELECT * FROM roles WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_array($result)) {
            generatePDF($row);
        }
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <title>

    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="mydetails.css">

</head>

<body>
    <div class="full-page">
        <div class="navbar">
            <div>
                <a href=''>
                    <?php echo "Check your details below  " . ($_SESSION['role'] == 2 ? " " . $_SESSION['username'] : $_SESSION['username']) . "!" ?>
                </a>
            </div>
            <div>

                <a href="loandetails2.php">
                    <button type="button" class="btn btn-primary">View Loan Details</button>
                </a>
                <a href="../Loan_Appraisal_System1/chartjs-project2/index.php">
                    <button type="button" class="btn btn-primary">Reports</button>
                </a>
            </div>
        </div>

        <h1 align="center" style="color:white;">My Details</h1>
        <br>
        <div class="card-body">
            <div class="table-responsive">
                <div class="container-fluid">
                <form action="" method="POST">
                    <!-- Add a hidden input for downloading PDF -->
                    <input type="hidden" name="download_pdf" value="1">
                    <input type="text" name="email" placeholder="Enter Email" />
                    <input type="submit" name="search" value="SEARCH BY EMAIL">
                </form>

                <!-- Wrap the "Download PDF" button inside the form -->
                <form action="" method="POST">
                    <input type="hidden" name="download_pdf" value="1">
                    <button type="submit" class="btn btn-primary">Download PDF</button>
                </form>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">CLient ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Firtsname</th>
                                <th scope="col">LastName</th>
                                <th scope="col">Phonenumber</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">Tax ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                            include('./db_connect.php');
                            if (isset($_POST['search'])) {
                                $email = $_POST['email'];
                                $query = "SELECT * FROM roles where email ='$email'";
                                $connect = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_array($connect)) {
                            ?>
                                    <tr>
                                        <td> <?php echo $row['roleID']; ?> </td>
                                        <td> <?php echo $row['username']; ?> </td>
                                        <td> <?php echo $row['firstname']; ?> </td>
                                        <td> <?php echo $row['lastname']; ?> </td>
                                        <td> <?php echo $row['phonenumber']; ?> </td>
                                        <td> <?php echo $row['email']; ?> </td>
                                        <td> <?php echo $row['address']; ?> </td>
                                        <td> <?php echo $row['tax_id']; ?> </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div>
                    <a href="Client.php">
                        <button type="button" class="btn">Go Back</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
