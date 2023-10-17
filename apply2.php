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
        $repaymentamnt = $_POST['repaymentamount'];
        $penalty = $_POST['penalty'];
       



    $sql = "INSERT INTO loan_repayment ( ref_number, payee, monthly_repayment_amount,penalty_amount,loanID ) VALUES ('$refno','$payee','$repaymentamnt','$loanID')";
    $query=mysqli_query($conn,$sql);

    if($query){
        $sql2 ="INSERT INTO loans (loan_ID, ref_number, clientID) Values ('$loanID','$refno',$clientID')";
        $result=mysqli_query($conn,$sql2);
      
        echo"<br>";
		echo header('location:payments.php?paymentapplication=success');

        
		}else{
        die("Error Inserting Data");
        }

 
?>

