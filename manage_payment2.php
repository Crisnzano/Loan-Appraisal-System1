<?php include('db_connect.php');?>

<?php 

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
	<title>New Payment Form</title>
	<link rel="stylesheet" href="manage_borrower.css">
</head>
<body>

<div class="wrapper">
    <div class="title">
      New Payment Form
    </div>
    <form action="apply2.php" method="POST">
    <div class="form">
    <div class="inputfield">
          <label>Reference No</label>
          <input type="number" class="input" name="ref_no">
       </div>  

         <div class="inputfield">
          <label>Payee</label>
          <input type="text" class="input" name="loan_amount">
       </div> 
      <div class="inputfield">
          <label>Repayment Amount</label>
          <input type="number" class="input" name="repaymentamount">
       </div> 
       <div class="inputfield">
          <label>Penalty</label>
          <input type="number" class="input" name="penalty">
       </div> 
       <div>
       		<button class="btn btn-primary btn-sm btn-block align-self-end" type="button" id="calculate">Calculate</button>
            </div>
       <div id="calculation_table">
			
		</div> 
       
      <div class="inputfield">
        <input type="submit" value="Save" class="btn" name="submit">
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
	
	$(document).ready(function(){
		if('<?php echo isset($_GET['id']) ?>' == 1)
			calculate()
	})
</script>	


	
</body>
</html>


