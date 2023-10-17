<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM roles where roleID=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
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
    <form action="signup.php" method="POST">
    <div class="form">
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
          <input type="password" class="input">
       </div> 
       
        <div class="inputfield">
          <label>Address</label>
          <input type="text" class="input" name="address">
       </div> 
      <div class="inputfield">
          <label>Phone Number</label>
          <input type="text" class="input" name="contact_no">
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
          <input type="text" class="input" name="national_id">
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
</div>	
	
</body>
</html>

<script>
	 $('#manage-borrower').submit(function(e){
	 	e.preventDefault()
	 	start_load()
	 	$.ajax({
	 		url:'ajax.php?action=save_borrower',
	 		method:'POST',
	 		data:$(this).serialize(),
	 		success:function(resp){
	 			if(resp == 1){
	 				alert_toast("Borrower data successfully saved.","success");
	 				setTimeout(function(e){
	 					location.reload()
	 				},1500)
	 			}
	 		}
	 	})
	 })
</script>