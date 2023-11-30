<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        p {
            margin: 10px 0;
        }

        input {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <form method="POST" action="">
        <h2>Calculator</h2>

        <?php
        $amount = $interest_rate = $period = NULL;
        $total_interest = $total_payable = $monthly_payable = 0;

        if (isset($_POST['compute'])) {
            $amount = $_POST['amount'];
            $interest_rate = $_POST['interest_rate'];
            $period = $_POST['period'];

            $total_interest = $amount * ($interest_rate / 100) * $period;
            $total_payable = $total_interest + $amount;
            $monthly_payable = $total_payable / $period;
        }
        ?>

        <p>Loan Amount: <input type="text" name="amount" value="<?= $amount; ?>" /></p>
        <p>Interest Rate: <input type="text" name="interest_rate" value="<?= $interest_rate; ?>" /></p>
        <p>Payment Period: <input type="text" name="period" value="<?= $period; ?>" /></p>
        <p><input type="submit" name="compute" value="Compute" /></p>

        <div class="result">
            Loan Amount: <?= number_format($amount, 2); ?><br />
            Total Interest: <?= number_format($total_interest, 2); ?><br />
            Total Payable: <?= number_format($total_payable, 2); ?><br />
            Monthly Payable: <?= number_format($monthly_payable, 2); ?>
        </div>
		<div>
        <a href="index.php?page=loans">
            <button type="button" class="btn">Go Back</button>
        </a>
            </div>
    </form>
</body>

</html>
