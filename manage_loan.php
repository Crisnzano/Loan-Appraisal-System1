<?php 
include('db_connect.php');
if(isset($_GET['loan_ID'])){
$qry = $conn->query("SELECT * FROM loans where loan_ID = ".$_GET['loan_ID']);
foreach($qry->fetch_array() as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
	<form action="" id="loan-application">
		<input type="hidden" name="id" value="<?php echo isset($_GET['loan_ID']) ? $_GET['loan_ID'] : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Client</label>
				<?php
				$borrower = $conn->query("SELECT *,concat(lastname,', ',firstname) as name FROM client order by concat(lastname,', ',firstname) asc ");
				?>
				<select name="borrower_id" id="borrower_id" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $borrower->fetch_assoc()): ?>
							<option value="<?php echo $row['client_ID'] ?>" <?php echo isset($borrower_id) && $borrower_id == $row['client_ID'] ? "selected" : '' ?>><?php echo $row['name'] . ' | TaxID:'.$row['tax_id'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Loan Type</label>
				<?php
				$type = $conn->query("SELECT * FROM loan_types order by `type_name` desc ");
				?>
				<select name="loan_type_id" id="loan_type_id" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $type->fetch_assoc()): ?>
							<option value="<?php echo $row['loan_typeID'] ?>" <?php echo isset($loan_type_id) && $loan_type_id == $row['loan_typeID'] ? "selected" : '' ?>><?php echo $row['type_name'] ?></option>
						<?php endwhile; ?>
				</select>
			</div>
			
		</div>

		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Loan Plan</label>
				<?php
				$plan = $conn->query("SELECT * FROM loan_plan order by `loan_tenure` desc ");
				?>
				<select name="plan_id" id="plan_id" class="custom-select browser-default select2">
					<option value=""></option>
						<?php while($row = $plan->fetch_assoc()): ?>
							<option value="<?php echo $row['planID'] ?>" <?php echo isset($plan_id) && $plan_id == $row['planID'] ? "selected" : '' ?> data-months="<?php echo $row['loan_tenure'] ?>" data-interest_percentage="<?php echo $row['interest_percentage'] ?>" data-penalty_rate="<?php echo $row['penalty_rate'] ?>"><?php echo $row['loan_tenure'] . ' month/s [ '.$row['interest_percentage'].'%, '.$row['penalty_rate'].'% ]' ?></option>
						<?php endwhile; ?>
				</select>
				<small>months [ interest%,penalty% ]</small>
			</div>
		<div class="form-group col-md-6">
			<label class="control-label">Loan Amount</label>
			<input type="number" name="amount" class="form-control text-right" step="any" id="" value="<?php echo isset($amount) ? $amount : '' ?>">
		</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
			<label class="control-label">Purpose</label>
			<textarea name="purpose" id="" cols="30" rows="2" class="form-control"><?php echo isset($purpose) ? $purpose : '' ?></textarea>
		</div>
		
		<div class="form-group col-md-2 offset-md-2 .justify-content-center">
			<label class="control-label">&nbsp;</label>
			<button class="btn btn-primary btn-sm btn-block align-self-end" type="button" id="calculate">Calculate</button>
		</div>
		</div>
		<?php if(isset($status)): ?>
		<div class="row">
			<div class="form-group col-md-6">
				<label class="control-label">&nbsp;</label>
				<select class="custom-select browser-default" name="status">
					<option value="0" <?php echo $status == 0 ? "selected" : '' ?>>Pending</option>
					<option value="1" <?php echo $status == 1 ? "selected" : '' ?>>Accepted</option>
					<?php if($status !='4' ): ?>
					<option value="2" <?php echo $status == 2 ? "selected" : '' ?>>Pending Loan</option>
					<?php endif ?>
					<?php if($status =='2' ): ?>
					<option value="3" <?php echo $status == 3 ? "selected" : '' ?>>Completed</option>
					<?php endif ?>
					<?php if($status !='2' ): ?>
					<option value="4" <?php echo $status == 4 ? "selected" : '' ?>>Rejected</option>
					<?php endif ?>
				</select>
			</div>
		</div>
		<hr>
	<?php endif ?>
		<div id="row-field">
			<div class="row ">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary btn-sm " >Save</button>
					<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
		
	</form>
	</div>
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
		if($('#loan_plan_id').val() == '' && $('[name="amount"]').val() == ''){
			alert_toast("Select plan and enter amount first.","warning");
			return false;
		}
		var plan = $("#planID option[value='"+$("#planID").val()+"']")
		$.ajax({
			url:"calculation_table.php",
			method:"POST",
			data:{amount:$('[name="amount"]').val(),months:plan.attr('data-months'),interest:plan.attr('data-interest_percentage'),penalty:plan.attr('data-penalty_rate')},
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