<?php
include('./db_connect.php');
if(isset($_GET['id'])){
    $id= $_GET['id'];
    $stat = $db->prepare(" SELECT l.*, p.monthly_repayment_amount AS pamount  FROM loans l,loan_repayment p where l.loan_ID = p.loanID And loan_ID = ? ");
    $stat->bindParam(1,$id);
    $stat->execute();
    $data = $stat->fetch();

    $file = 'media/'.$data['firstname'];

    if(file_exists($file)){
        header('Content-NationalID:'.$data['nationalID']);
        header('Content-Phonenumber:'.$data['phonenumber']);
        header('Content-Address:'.$data['address']);
        header('Content-Email:'.$data['email'].'; firstname="'.basename($file).'"');
        header('Content-Length:'.filesize($file));
        readfile($file);
        exit;
    }

}