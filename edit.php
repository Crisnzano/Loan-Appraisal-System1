<?php include('db_connect.php');

$StaffID= $_GET['GetID'];
$query = " SELECT * from staff where staffID ='".$StaffID."'";
$result = mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($result))
{
   $StaffID =$row['staffID'];
   $Firstname =$row['firstname'];
   $Lastname =$row['lastname'];
   $Rolename =$row['role_name'];
   $NationalID =$row['nationalID'];
   $Phonenumber=$row['phonenumber'];
   $Email =$row['email'];
   $Address =$row['address'];
   $TaxID =$row['tax_id'];
   $Approvalstatus=$row['approval_status'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Admin Details Form</title>
	<link rel="stylesheet" href="manage_borrower.css">
</head>
<body>

<div class="wrapper">
    <div class="title">
      Edit Admin Details Form
    </div>
    <form action="update.php?ID =<?php echo $StaffID ?>" method="POST">
    <div class="form">
    <div class="inputfield">
          <label> Firstname</label>
          <input type="text" class="input" name="firstname" value="<?php echo $Firstname ?>">
       </div> 
         <div class="inputfield">
          <label>Lastname</label>
          <input type="text" class="input" name="lastname" value="<?php echo $Lastname ?>">
       </div> 
      <div class="inputfield">
          <label>nationalID</label>
          <input type="number" class="input" name="nationalID" value="<?php echo $NationalID ?>">
       </div> 
       <div class="inputfield">
          <label>Phonenumber</label>
          <input type="number" class="input" name="phonenumber" value="<?php echo $Phonenumber ?>">
       </div>
       <div class="inputfield">
          <label>Adress</label>
          <input type="text" class="input" name="address" value="<?php echo $Address ?>">
       </div>
       <div class="inputfield">
          <label>Email</label>
          <input type="text" class="input" name="email" value="<?php echo $Email ?>">
       </div>
       
       <div class="inputfield">
          <label>Approval Status</label>
          <?php 
          $query = "SELECT approval_status FROM  staff";
          $result = mysqli_query($conn,$query);
          ?>

          
          <select id ="" class="input" name="approval_status">
          <optgroup label="Approval Status">
          	<?php while($row = mysqli_fetch_array($result)) ?>
				<option value="1" <?php echo isset($meta['approval_status']) && $meta['approval_status'] == 1 ? 'selected': '' ?>>Accepted</option>
				<option value="2" <?php echo isset($meta['approval_status']) && $meta['approval_status'] == 2 ? 'selected': '' ?>>Rejected</option>
          </optgroup>
        </select>
       </div> 
      <div class="inputfield">
        <button  class="btn" name="update">Update</button>
        
      </div>
       <div><a href="reports3.php">
                <button type="button" class="btn">Go Back</button></a>
            </div>
    </div>
    
    </form>        
</div>

</body>
</html>


