
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClientPage</title>
    <link rel="stylesheet" href="client.css">

<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['name']));
/*header("location:index.php?page=home");*/
?>
</head>
<body>
 
 <div class="full-page">
        <div class="navbar">
            <div>
                <a href=''>
                    <?php echo "Welcome back ".($_SESSION['role'] == 3 ? " ".$_SESSION['username'] : $_SESSION['username'])."!"  ?>
                </a>
            </div>
            <nav>
                <ul id='MenuItems'>
                    <li><a href='Homepage.php'>Home</a></li>
                    <li><a href='reports.php'>View reports</a></li>
                    <li><a href='reports3.php'>View Staff Details</a></li>
                    <li><a href="Homepage.php"><button type='button' class='toggle-btn'>Logout</button></a></li>
                </ul>
            </nav>
        </div>
    </div>
  
</body>
</body>
</html>