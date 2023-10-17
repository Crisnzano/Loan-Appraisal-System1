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
                    <?php echo "Check your details below  ".($_SESSION['role'] == 2 ? " ".$_SESSION['username'] : $_SESSION['username'])."!"  ?>
                </a>
            </div>
            <div><a href="">
                <button type="button" class="btn btn-outline-primary">Download PDF</button></a>
        
                <a href="loandetails2.php">
                <button type="button" class="btn btn-outline-primary">View Loan Details</button></a>
            </div>
            
</div>

<h1 align="center" style="color:deepskyblue;">My Details</h1>
<br>
<div class="card-body">
    <div class ="table-responsive">
    <div class="container-fluid">
   <form action=""method="POST">
        <input type="text"name="username"placeholder="Enter Username"/>
        <input type="submit"name="search"value="SEARCH BY USERNAME">
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
    if(isset($_POST['search']))
{
   $username=$_POST['username'];
   $query="SELECT * FROM roles where username ='$username'";
   $connect=mysqli_query($conn,$query);
   
            while($row= mysqli_fetch_array($connect))

        {
            ?>
            <tr>
            
            <td> <?php echo $row['roleID'];?> </td>
            <td> <?php echo $row['username'];?> </td>
            <td> <?php echo $row['firstname'];?> </td>
            <td> <?php echo $row['lastname'];?> </td>
            <td> <?php echo $row['phonenumber'];?> </td>
            <td> <?php echo $row['email'];?> </td>
            <td> <?php echo $row['address'];?> </td>
            <td> <?php echo $row['tax_id'];?> </td>
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