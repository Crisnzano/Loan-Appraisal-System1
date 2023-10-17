<?php 
include('db_connect.php');
if(isset($_GET['name'])){
$qry = $conn->query("SELECT * FROM roles where username = '$username'");
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
	<title>Loanapplication Form</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css">
	<link rel="stylesheet" href="loanapplication.css">
</head>
<body>

<div class="wrapper">
    <div class="title">
      Registration Form
    </div>
    <form action=" " method="POST" id="loan-application">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
    <div class="form">
       <div class="inputfield">
          <label>Client Name</label>
          	<?php
				$borrower = $conn->query("SELECT *,concat(lastname,', ',firstname) as name FROM roles order by concat(lastname,', ',firstname) asc ");
				?>
				<select name="borrower_id" id="" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $borrower->fetch_assoc()): ?>
							<option value="<?php echo $row['roleID'] ?>" <?php echo isset($borrower_id) && $borrower_id == $row['roleID'] ? "selected" : '' ?>><?php echo $row['name'] . ' | TaxID:'.$row['tax_id'] ?></option>
						<?php endwhile; ?>
				</select>
       </div>  
        <div class="inputfield">
          <label>Loan Type</label>
          <?php
				$type = $conn->query("SELECT * FROM loan_types order by 'type_name'desc ");
				?>
				<select name="loan_type_id" id="" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $type->fetch_assoc()): ?>
							<option value="<?php echo $row['loan_typeID'] ?>" <?php echo isset($loan_type_id) && $loan_type_id == $row['loan_typeID'] ? "selected" : '' ?>><?php echo $row['type_name'] ?></option>


						<?php endwhile; ?>
				</select>
       </div>  
       <div class="inputfield">
          <label>Loan Plan</label>
          <?php
				$plan = $conn->query("SELECT * FROM loan_plan ");
				?>
				<select name="plan_id" id="" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $plan->fetch_assoc()): ?>
							<option value="<?php echo $row['planID'] ?>" <?php echo isset($plan_id) && $plan_id == $row['planID'] ? "selected" : '' ?> data-months="<?php echo $row['loan_tenure'] ?>" data-interest_percentage="<?php echo $row['interest_percentage'] ?>" data-penalty_rate="<?php echo $row['penalty_rate'] ?>"><?php echo $row['loan_tenure'] . ' month/s [ '.$row['interest_percentage'].'%, '.$row['penalty_rate'].'% ]' ?></option>
						<?php endwhile; ?>
				</select>
				<small>[int&pen% ]</small>
       </div>  
      <div class="inputfield">
          <label>Loan Amount</label>
          <input type="number" name="amount" step="any" id="" value="<?php echo isset($amount) ? $amount : '' ?>">
       </div> 
       
      <div class="inputfield">
          <label>Purpose</label>
          <textarea class="textarea" name="purpose" id=""></textarea>
       </div> 
      <div class="inputfield terms">
          <label class="check">
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
          <p>Agreed to terms and conditions</p>
       </div> 

       <div>
       		<a href="calculation_table2.php"><button class="btn btn-primary btn-sm btn-block align-self-end" type="button" id="calculate">Calculate</button></a>
            </div>
       <div id="calculation_table">
			
		</div>

		<div id="row-field">
			<div class="inputfield">
					<button class="btn btn-primary btn-sm " type="submit">Save</button>
					<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
				
			</div>
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
<style>
	#uni_modal .modal-footer{
		display: none
	}
</style>
	
</body>
</html>

</body>
</html>

