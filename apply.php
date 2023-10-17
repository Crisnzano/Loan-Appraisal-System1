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
       
       
    
        $loantype= $_POST['loan_type'];
        $plan = $_POST['loan_plan'];
        $amount = $_POST['loan_amount'];
        $purpose= $_POST['purpose'];
        $refno= generateKey();
        $clientID = generateKey3();
        $status=0;
        $loanID = generateKey3();
        $payee = $_POST['payee'];
        $repaymentamnt = $_POST['repayment_amount'];
       



    $sql = "INSERT INTO loans ( clientID, purpose, loan_type_id, ref_number, loan_amount, planID, loan_status, loan_ID) VALUES ('$clientID','$purpose','$loantype','$refno', '$amount', '$plan','$status','$loanID')";
    $query=mysqli_query($conn,$sql);

    if($query){
        $sql2 ="INSERT INTO loan_repayment (loanID,payee,monthly_repayment_amount) Values ('$loanID','$payee','$repaymentamnt')";
        $result=mysqli_query($conn,$sql2);
      
        $_SESSION['status'] = "Data Updated Successfully ,your reference number is $refno";
        header("Location: loanapplication.php?application=success");
        

    }else{
        $_SESSION['status'] = "Not Updated";
        header("Location: index.php?page=loans ");
        }
 
    
 
?>

