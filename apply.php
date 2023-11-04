<?php
     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    include'db_connect.php';

        function generateKey(){
            $keyLength=6;
            $str="1234567890";
            $randStr=substr(str_shuffle($str),0,$keyLength);
            return$randStr;
        }
         function generateKey2(){
            $keyLength=1;
            $str="1234567890";
            $randStr=substr(str_shuffle($str),0,$keyLength);
            return$randStr;
        }
         function generateKey3(){
            $keyLength=1;
            $str="123456789";
            $randStr=substr(str_shuffle($str),0,$keyLength);
            return$randStr;
        }
        function getClientID(){
        } 
        function test_input($data){
            $data = trim($data);
            $data = stripcslashes($data);
            return $data;
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

       // Define error variables
$payeeErr = $loanAmountErr = $repaymentAmountErr = "";

// Initialize variables to hold user inputs
$payee = $loan_amount = $purpose = $loan_type = $loan_plan = $repayment_amount = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate Client Name
  if (empty($_POST['payee'])) {
      $payeeErr = "Client Name is required";
  } else {
      $payee = $_POST['payee'];
  }

  // Validate Loan Amount
  if (empty($_POST['loan_amount'])) {
      $loanAmountErr = "Loan Amount is required";
  } else {
      $loan_amount = $_POST['loan_amount'];
  }
   // Validate Repayment Amount
   if (empty($_POST['repayment_amount'])) {
    $repaymentAmountErr = "Repayment Amount is required";
} else {
    $repayment_amount = $_POST['repayment_amount'];
}
}

    $sql = "INSERT INTO loans ( clientID, purpose, loan_type_id, ref_number, loan_amount, planID, loan_status, loanID) VALUES ('$clientID','$purpose','$loantype','$refno', '$amount', '$plan','$status','$loanID')";
    $query=mysqli_query($conn,$sql);

    if($query){
        $sql2 ="INSERT INTO loan_repayment (loanID,payee,monthly_repayment_amount) Values ('$loanID','$payee','$repaymentamnt')";
        $result=mysqli_query($conn,$sql2);
      
        $_SESSION['status'] = "Data Updated Successfully ,your reference number is "; echo $refno;
        header("Location: loanapplication.php?application=success");
        

    }else{
        $_SESSION['status'] = "Not Updated";
        header("Location: index.php?page=loans ");
        }
 
    
 
?>

