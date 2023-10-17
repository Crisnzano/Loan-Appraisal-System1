<!doctype html>

<html>

	<head>

		<title> Calculator</title>

	</head>

	<body>

		<form method="POST" action="">

			<h2>Calculator</h2>

<?php

$amount=$interest_rate=$period=NULL;

$total_interest=$total_payable=$monthly_payable=0;

if(isset($_POST['compute'])){

	$amount=$_POST['amount'];

	$interest_rate=$_POST['interest_rate'];

	$period=$_POST['period'];

	

	$total_interest=$amount*($interest_rate/100)*$period;

	$total_payable=$total_interest+$amount;

	$monthly_payable=$total_payable/$period;

}

?>

			<p>Loan Amount: <input type="text" name="amount" size="8" value="<?=$amount;?>"/></p>

			<p>Interest Rate: <input type="text" name="interest_rate" size="8" value="<?=$interest_rate;?>"/></p>

			<p>Payment Period: <input type="text" name="period" size="8" value="<?=$period;?>"/></p>

			<p><input type="submit" name="compute" value="Compute"/></p>

			<p>

				Loan Amount: <?=number_format($amount, 2);?><br/>

				Total Interest: <?=number_format($total_interest, 2);?><br/>

				Total Payable: <?=number_format($total_payable, 2);?><br/>

				Monthly Payable: <?=number_format($monthly_payable, 2);?>

			</p>

		</form>

	</body>

</html>

