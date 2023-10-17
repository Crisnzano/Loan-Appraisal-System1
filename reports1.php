    <?php include('./db_connect.php');

    session_start();
    if(isset($_SESSION['name']));
                                              
    $query="SELECT * FROM staff ";
    $connect=mysqli_query($conn,$query);
    $data=mysqli_fetch_assoc($connect);
    $num=mysqli_num_rows($connect);

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
                    <?php echo "Check details below  ".($_SESSION['role'] == 2 ? " ".$_SESSION['username'] : $_SESSION['username'])."!"  ?>
                </a>
            </div>
            <div><a href="reports2.php">
                <button type="button" class="btn btn-outline-primary">Loan Details</button></a>
                <a href=""><button type="button" class="btn btn-outline-primary">Download PDF</button></a>
            </div>

            
</div>

<h1 align="center" style="color:deepskyblue;">Staff Details</h1>
<br>
<div class="card-body">
    <div class ="table-responsive">
        
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Staff ID</th>
      <th scope="col">Firtsname</th>
      <th scope="col">LastName</th>
      <th scope="col">Rolename</th>
      <th scope="col">NationalID</th>
      <th scope="col">Phonenumber</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">Tax ID</th>
      <td>Edit</td>
      <td>Delete</td>
    </tr>
  </thead>
  <tbody>
    <?php
    if($num>0)
    {
        while($data=mysqli_fetch_assoc($connect)){
            echo "

             <tr>
            
            <td>".$data['staffID']."</td>
            <td>".$data['firstname']."</td>
            <td>".$data['lastname']."</td>
            <td>".$data['role_name']."</td>
            <td>".$data['nationalID']."</td>
            <td>".$data['phonenumber']."</td>
            <td>".$data['email']."</td>
            <td>".$data['address']."</td>
            <td>".$data['tax_id']."</td>
            </tr>

            ";
        }
    }

    ?>
    <tr>
    <td><a href ="update.php?GetID" >Edit</a></td>
    <td><a href ="" >Delete</a></td>
    </tr>
  </tbody>
</table>
    </div>
     <div><a href="Manager.php">
                <button type="button" class="btn btn-outline-primary">Go Back</button></a>
            </div>
</div>
</div>
</body>
</html>