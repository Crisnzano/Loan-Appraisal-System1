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

// Define error variables
$payeeErr = $loanAmountErr = $repaymentAmountErr = "";

// Initialize variables to hold user inputs
$payee = $loan_amount = $purpose = $loan_type = $loan_plan = $repayment_amount = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate Client Name
  if (empty($_POST['payee'])) {
    $payeeErr = "Client Name is required";
  } else if (!preg_match("/^[a-zA-Z ]*$/", $_POST['payee'])) {
    $payeeErr = "Only letters and white space allowed";
  } else {
    $payee = test_input($_POST['payee']);
  }

  // Validate Loan Amount
  if (empty($_POST['loan_amount'])) {
      $loanAmountErr = "Loan Amount is required";
  } else {
    $loan_amount = test_input($_POST['loan_amount']);
  }

   // Validate Repayment Amount
   if (empty($_POST['repayment_amount'])) {
    $repaymentAmountErr = "Repayment Amount is required";
  } else {
    $repayment_amount = test_input($_POST['repayment_amount']);
  }

 // If all inputs are valid, you can proceed to save the data to the database
 if (empty($payeeErr) && empty($loanAmountErr) && empty($repaymentAmountErr)) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    function generateKey(){
      $keyLength=6;
      $str="1234567890";
      $randStr=substr(str_shuffle($str),0,$keyLength);
      return $randStr;
    }
    function generateKey2(){
      $keyLength=1;
      $str="1234567890";
      $randStr=substr(str_shuffle($str),0,$keyLength);
      return $randStr;
    }
    function generateKey3(){
      $keyLength=1;
      $str="123456789";
      $randStr=substr(str_shuffle($str),0,$keyLength);
      return $randStr;
    }

    $loantype= htmlspecialchars($_POST['loan_type']);
    $plan = htmlspecialchars($_POST['loan_plan']);
    $amount = htmlspecialchars($_POST['loan_amount']);
    $purpose= htmlspecialchars($_POST['purpose']);
    $refno= generateKey();
    $clientID = generateKey2();
    $status=0;
    $loanID = generateKey3();
    $payee = htmlspecialchars($_POST['payee']);
    $repaymentamnt = htmlspecialchars($_POST['repayment_amount']);

    $sql = "INSERT INTO loans ( clientID, purpose, loan_type_id, ref_number, loan_amount, planID, loan_status, loanID) VALUES ('$clientID','$purpose','$loantype','$refno', '$amount', '$plan','$status','$loanID')";
    $query=mysqli_query($conn,$sql);

    if($query){
        $sql2 ="INSERT INTO loan_repayment (loanID,payee,monthly_repayment_amount) Values ('$loanID','$payee','$repaymentamnt')";
        $result=mysqli_query($conn,$sql2);

        $_SESSION['status'] = "Data Updated Successfully ,your reference number is "; echo $refno;
        alert_toast("Loan Data successfully saved.","success");
        header("Location: index.php?page=loans&message=" . urlencode("Loan Application was added successfully."));
        exit();
    } else {
        $_SESSION['status'] = "Not Updated";
        alert_toast("Loan Data has not been saved.");
        header("Location: index.php?page=loans ");
        exit();
    }
  }
}

// Function to sanitize user inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application Form</title>
    <link rel="stylesheet" href="manage_borrower.css">
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<div class="wrapper">
    <div class="title">
      Loan Application Form
    </div>
    <form action="loanapplication2.php" method="POST">
    <div class="form">
    <div class="inputfield">
          <label>Client Name</label>
          <input type="text" class="input" name="payee" placeholder="Client Name" required>
          <span class="error">* <?php echo $payeeErr; ?></span>
       </div> 
         <div class="inputfield">
          <label>Loan Amount</label>
          <input type="number" class="input" name="loan_amount" placeholder="Amount in Ksh" required>
          <span class="error">* <?php echo $loanAmountErr; ?></span>
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
          <input type="number" class="input" name="repayment_amount" placeholder="Repayment Amount" required>
          <span class="error">* <?php echo $repaymentAmountErr; ?></span>
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
      
      <div class="inputfield" ><a href="http://localhost:8502">
                <button type="button" class="btn">Want to check if you are eligible for your loan? Click here </button></a>
            </div>

      <div class="inputfield">
        <input type="submit" value="Save" class="btn" name="submit">
        
      </div>
      <div>
        <a href="index.php?page=loans">
            <button type="button" class="btn">Go Back</button>
        </a>
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
</script>    


</body>
</html>
