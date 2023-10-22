<?php include('db_connect.php');?>

<?php 
session_start();

include('db_connect.php');
if(isset($_GET['name'])){
$qry = $conn->query("SELECT * FROM roles where username = ".$_GET['username']);
foreach($qry->fetch_array() as $k => $v){
	$$k = $v;
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Loan Application Form</title>
	<link rel="stylesheet" href="manage_borrower.css">
</head>
<body>

<div class="wrapper">
    <div class="title">
	<?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                ?>
      Loan Application Form
    </div>
    <form action="apply.php" method="POST">
    <div class="form">
    <div class="inputfield">
          <label>Client Name</label>
          <input type="text" class="input" name="payee" placeholder="Client Name">
       </div> 
         <div class="inputfield">
          <label>Loan Amount</label>
          <input type="number" class="input" name="loan_amount" placeholder="Amount in Ksh">
       </div> 
      <div class="inputfield">
          <label>Purpose</label>
          <textarea type="text" class="input" name="purpose" placeholder="Loan Purpose"></textarea>
       </div> 
       <div class="inputfield">
          <label>Loan Type</label>
          <?php 
          $query = "SELECT * FROM  loan_types";
          $result = mysqli_query($conn,$query);
          ?>

          
          <select id ="loan_type" class="input" name="loan_type">
          <optgroup label="Types">
          	<?php while($row = mysqli_fetch_array($result)) ?>
				<option value="1" <?php echo isset($meta['loan_type']) && $meta['loan_type'] == 1 ? 'selected': '' ?>>Student Loan</option>
				<option value="2" <?php echo isset($meta['loan_type']) && $meta['loan_type'] == 2 ? 'selected': '' ?>>Personal Loan</option>
				<option value="3" <?php echo isset($meta['loan_type']) && $meta['loan_type'] == 3 ? 'selected': '' ?>>Mortgage Loan</option>
          </optgroup>
        </select>
       </div> 
    
       <div class="inputfield">
          <label>Loan Plan</label>
          <?php 
          $query = "SELECT * FROM  loan_plan ";
          $result = mysqli_query($conn,$query);
          ?>

          <select id="loan_plans" class="input" name="loan_plan">
          <optgroup label="Plans">
          	<?php while($row = mysqli_fetch_array($result)) ?>
        <option value="1" <?php echo isset($meta['loan_plans']) && $meta['loan_plans'] == 1 ? 'selected': '' ?>>36months,8%int,3penrate</option>
				<option value="2" <?php echo isset($meta['loan_plans']) && $meta['loan_plans'] == 2 ? 'selected': '' ?>>24months,5%int,2penrate</option>
				<option value="3" <?php echo isset($meta['loan_plans']) && $meta['loan_plans'] == 3 ? 'selected': '' ?>>27months,6%int,3penrate</option>	

          	
          </optgroup>
        </select>
        
       </div> 
	   <div class="inputfield">
          <label>Repayment Amount</label>
          <input type="number" class="input" name="repayment_amount" placeholder="Repayment Amount">
       </div>
       <div>
       		<a href="calculation_table2.php"><button class="btn btn-primary btn-sm btn-block align-self-end" type="button" id="calculate">Calculate</button></a>
            </div>
       <div id="calculation_table">
			
		</div>
      <div class="inputfield terms">
          <label class="check">
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
          <p>Agree to terms and conditions</p>
       </div> 
      
      <div class="inputfield" ><a href="http://localhost:8501">
                <button type="button" class="btn">Want to check if you are eligible for your loan? Click here </button></a>
            </div>

      <div class="inputfield">
        <input type="submit" value="Save" class="btn" name="submit">
        
      </div>

        <div><a href="Client.php">
                <button type="button" class="btn">Go Back</button></a>
            </div>
    </div>
    
    </form>        
</div>

<script>
  
	
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})
	$('#calculate').click(function(){
		calculate()
	})
	

	function calculate(){
		start_load()
		if($('#loan_plan_id').val() == '' && $('[name="loan_amount"]').val() == ''){
			alert_toast("Select plan and enter amount first.","warning");
			return false;
		}
		var plan = $("#planID option[value='"+$("#planID").val()+"']")
		$.ajax({
			url:"calculation_table.php",
			method:"POST",
			data:{amount:$('[name="loan_amount"]').val(),months:plan.attr('data-loan_tenure'),interest:plan.attr('data-interest_percentage'),penalty:plan.attr('data-penalty_rate')},
			success:function(resp){
				if(resp){
					
					$('#calculation_table').html(resp)
					end_load()
				}
			}

		})
	}
	$('#loan-application').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_loan',
			method:"POST",
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1 ){
					$('.modal').modal('hide')
					alert_toast("Loan Data successfully saved.","success")
					setTimeout(function(){
						location.reload();
					},1500)
				}
			}
		})
	})
	$(document).ready(function(){
		if('<?php echo isset($_GET['id']) ?>' == 1)
			calculate()
	})
</script>	


	
</body>
</html>


