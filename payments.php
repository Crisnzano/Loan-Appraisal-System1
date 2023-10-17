<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Payment List</b>
					<button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" id="new_payments"><i class="fa fa-plus"></i> New Payment</button>
				</large>
				
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">Repayment ID</th>
							<th class="text-center">Loan Reference No</th>
							<th class="text-center">Payee</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Penalty</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
						 include('./db_connect.php');
						 
						 $query="SELECT p.*, l.ref_number AS rnumber FROM loan_repayment p,loans l where p.loanID = l.loanID AND l.loan_status=1";
						 $connect=mysqli_query($conn,$query);
						 
								 while($row= mysqli_fetch_array($connect))
						 
							 {
								 ?>	
							 
					 <tr>
						 
						 <td> <?php echo $row['re_paymentID'];?> </td>
						 <td> <?php echo $row['rnumber'];?> </td>
						 <td> <?php echo $row['payee'];?> </td>
						 <td> <?php echo $row['monthly_repayment_amount'];?> </td>
						 <td> <?php echo $row['penalty_amount'];?> </td>
						 <td class="text-center"> 
							 <button class="btn btn-outline-primary btn-sm edit_loan" type="button" data-id="<?php echo $row['rnumber'] ?>"><i class="fa fa-edit"></i></button>
							  <button class="btn btn-outline-danger btn-sm delete_loan" type="button" data-id="<?php echo $row['rnumber'] ?>"><i class="fa fa-trash"></i></button>
						  </td>
 
						  </tr>
						  <?php
							 }
 
						 ?>

						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#loan-list').dataTable()
	$('#new_payments').click(function(){
		uni_modal("New Payement","manage_payment2.php",'mid-large')
	})
	$('.edit_payment').click(function(){
		uni_modal("Edit Payement","manage_payment.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_payment').click(function(){
		_conf("Are you sure to delete this data?","delete_payment",[$(this).attr('data-id')])
	})
function delete_payment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Payment successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>