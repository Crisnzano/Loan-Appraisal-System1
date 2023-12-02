<?php

	include'db_connect.php';

	function generateKey3(){
		$keyLength=2;
		$str="123456789";
		$randStr=substr(str_shuffle($str),0,$keyLength);
		return$randStr;
	}


	    $firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username=$_POST['username'];
		$address = $_POST['address'];
		$contact_no = $_POST['contact_no'];
		$email = $_POST['email'];
		$tax_id = $_POST['tax_id'];
		$password= $_POST['password'];
		$type=2;
		$national_id= $_POST['national_id'];
		$clientid=generateKey3();


	$sql = "INSERT INTO roles (firstname, lastname, username,address, phonenumber, email, tax_id, password, type ) VALUES ('$firstname', '$lastname','$username','$address','$contact_no', '$email', '$tax_id', '$password','$type')";
	$query=mysqli_query($conn,$sql);
	if($query){
        $sql2 ="INSERT INTO client (firstname, lastname, username,address, phonenumber, email, tax_id, password, type, nationalID, clientID) Values ('$firstname', '$lastname','$username','$address','$contact_no', '$email', '$tax_id', '$password','$type','$national_id','$clientid')";
        $result=mysqli_query($conn,$sql2);
		echo"<br>";
		echo header('location:login.php');
		}else{
		die("Error Inserting Data");
		}
 
	
 
?>

