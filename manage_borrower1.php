<?php
include 'db_connect.php';

$errors = array(); // Initialize an array to store validation errors

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM roles where roleID=" . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}

// Validate form submission
if (isset($_POST['submit'])) {
    // Validate first name
    if (empty($_POST['firstname'])) {
        $errors['firstname'] = "First name is required";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $_POST['firstname'])) {
        $errors['firstname'] = "First name should contain only letters";
    } else {
        $firstname = $_POST['firstname'];
    }

    // Validate last name
    if (empty($_POST['lastname'])) {
        $errors['lastname'] = "Last name is required";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $_POST['lastname'])) {
        $errors['lastname'] = "Last name should contain only letters";
    } else {
        $lastname = $_POST['lastname'];
    }

    // Validate username
    if (empty($_POST['username'])) {
        $errors['username'] = "Username is required";
    } else {
        $username = $_POST['username'];
    }

    // Validate password
    if (empty($_POST['password'])) {
        $errors['password'] = "Password is required";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    // Validate confirmed password
    if (empty($_POST['confirm_password'])) {
        $errors['confirm_password'] = "Confirm password is required";
    } elseif ($_POST['confirm_password'] !== $_POST['password']) {
        $errors['confirm_password'] = "Passwords do not match";
    } else {
        $confirm_password = $_POST['confirm_password'];
    }

    // Validate address
    if (empty($_POST['address'])) {
        $errors['address'] = "Address is required";
    } else {
        $address = $_POST['address'];
    }

    // Validate phone number
    if (empty($_POST['contact_no'])) {
        $errors['contact_no'] = "Phone number is required";
    } elseif (!is_numeric($_POST['contact_no'])) {
        $errors['contact_no'] = "Phone number should contain only numbers";
    } else {
        $contact_no = $_POST['contact_no'];
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } else {
        $email = $_POST['email'];
    }

    // Validate tax ID
    if (empty($_POST['tax_id'])) {
        $errors['tax_id'] = "Tax ID is required";
    } else {
        $tax_id = $_POST['tax_id'];
    }

    // Validate national ID
    if (empty($_POST['national_id'])) {
        $errors['national_id'] = "National ID is required";
    } elseif (!is_numeric($_POST['national_id'])) {
        $errors['national_id'] = "National ID should contain only numbers";
    } else {
        $national_id = $_POST['national_id'];
    }

    if (empty($errors)) {
        // Continue processing form data or save to the database
        include 'db_connect.php';

        function generateKey3()
        {
            $keyLength = 1;
            $str = "123456789";
            $randStr = substr(str_shuffle($str), 0, $keyLength);
            return $randStr;
        }

        $clientid = generateKey3();

        $sql = "INSERT INTO roles (firstname, lastname, username,address, phonenumber, email, tax_id, password, type ) VALUES ('$firstname', '$lastname','$username','$address','$contact_no', '$email', '$tax_id', '$password','2')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $sql2 = "INSERT INTO client (firstname, lastname, username,address, phonenumber, email, tax_id, password, type, nationalID, clientID) Values ('$firstname', '$lastname','$username','$address','$contact_no', '$email', '$tax_id', '$password','2','$national_id','$clientid')";
            $result = mysqli_query($conn, $sql2);

            echo "</div>";
            $msg = "<div class='alert alert-info'>Client added successfully.</div>";

            // Redirect to the specified page with the message parameter
            header("Location: index.php?page=borrowers&message=" . urlencode("Client added successfully."));
            exit();

        } else {
            die("Error Inserting Data");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="manage_borrower.css">
</head>

<body>

    <div class="wrapper">
        <div class="title">
            Registration Form
        </div>
        <form action="manage_borrower1.php" method="POST">
            <div class="form">
                <!-- Add error messages for validation -->
                <?php if (!empty($errors)) : ?>
                    <div class="errors" style="color: red;">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <!-- Display success message -->
                <?php if (isset($msg)) : ?>
                    <?php echo $msg; ?>
                <?php endif; ?>
                <div class="inputfield">
                    <label>First Name</label>
                    <input type="text" class="input" name="firstname">
                </div>
                <div class="inputfield">
                    <label>Last Name</label>
                    <input type="text" class="input" name="lastname">
                </div>
                <div class="inputfield">
                    <label>Username</label>
                    <input type="text" class="input" name="username">
                </div>
                <div class="inputfield">
                    <label>Password</label>
                    <input type="password" class="input" name="password">
                </div>
                <div class="inputfield">
                    <label>Confirm Password</label>
                    <input type="password" class="input" name="confirm_password">
                </div>
                <div class="inputfield">
                    <label>Address</label>
                    <input type="text" class="input" name="address">
                </div>
                <div class="inputfield">
                    <label>Phone Number</label>
                    <input type="number" class="input" name="contact_no">
                </div>
                <div class="inputfield">
                    <label>Email</label>
                    <input type="text" class="input" name="email">
                </div>
                <div class="inputfield">
                    <label>Tax ID</label>
                    <input type="text" class="input" name="tax_id">
                </div>
                <div class="inputfield">
                    <label>National ID</label>
                    <input type="number" class="input" name="national_id">
                </div>
                <div class="inputfield terms">
                    <label class="check">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <p>Agreed to terms and conditions</p>
                </div>
                <div class="inputfield">
                    <input type="submit" value="Register" class="btn" name="submit">
                </div>
            </div>
        </form>
    </div>

</body>

</html>
