<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM roles where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM roles where username = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../Loan_Appraisal_System1/complete-login-register-form-with-email-verification-main/index.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../Homepage.php");
	}

	function save_user(){
		extract($_POST);
		$data = " firstname = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO roles set ".$data);
		}else{
			$save = $this->db->query("UPDATE roles set ".$data." where roleID = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = "  firstname= '$name' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM roles where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO roles set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM roles where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " role_name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['role_name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_loan_type(){
		extract($_POST);
		$data = " type_name = '$type_name' ";
		$data .= " , description = '$description' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_types set ".$data);
		}else{
			$save = $this->db->query("UPDATE loan_types set ".$data." where loan_typeID=".$id);
		}
		if($save)
			return 1;
	}
	function delete_loan_type(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_types where loan_typeID = ".$id);
		if($delete)
			return 1;
	}
	function save_plan(){
		extract($_POST);
		$data = " loan_tenure = '$months' ";
		$data .= ", interest_percentage = '$interest_percentage' ";
		$data .= ", penalty_rate = '$penalty_rate' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_plan set ".$data);
		}else{
			$save = $this->db->query("UPDATE loan_plan ".$data." where planID=".$id);
		}
		if($save)
			return 1;
	}
	function delete_plan(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_plan where planID = ".$id);
		if($delete)
			return 1;
	}
	function save_borrower(){
		extract($_POST);
		$data = " lastname = '$lastname' ";
		$data .= ", firstname = '$firstname' ";
		$data .= ", address = '$address' ";
		$data .= ", phone number = '$contact_no' ";
		$data .= ", email = '$email' ";
		$data .= ", tax_id = '$tax_id' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO client set ".$data);
		}else{
			$save = $this->db->query("UPDATE client set ".$data." where clientID=".$id);
		}
		if($save)
			return 1;
	}
	function delete_borrower(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM client where clientID = ".$id);
		if($delete)
			return 1;
	}
	
	function save_loan(){
		extract($_POST);
			$data = " clientID = $borrower_id ";
			$data .= " , loan_type_id = '$loan_type_id' ";
			$data .= " , planID = '$plan_id' ";
			$data .= " , loan_amount = '$amount' ";
			$data .= " , purpose = '$purpose' ";
			if(isset($status)){
				$data .= " , status = '$status' ";
				if($status == 2){
					$plan = $this->db->query("SELECT * FROM loan_plan where planID = $plan_id ")->fetch_array();
					for($i= 1; $i <= $plan['loan_tenure'];$i++){
						$date = date("Y-m-d",strtotime(date("Y-m-d")." +".$i." loan_tenure"));
					$chk = $this->db->query("SELECT * FROM loan_schedules where loan_ID = $id and date(repayment_end_date) ='$date'  ");
					if($chk->num_rows > 0){
						$ls_id = $chk->fetch_array()['scheduleID'];
						$this->db->query("UPDATE loan_schedules set loan_ID = $id, repayment_end_date ='$date' where scheduleID = $ls_id ");
					}else{
						$this->db->query("INSERT INTO loan_schedules set loan_ID = $id, repayment_end_date ='$date' ");
						$ls_id = $this->db->insert_id;
					}
					$sid[] = $ls_id;
					}
					$sid = implode(",",$sid);
					$this->db->query("DELETE FROM loan_schedules where loan_ID = $id and scheduleID not in ($sid) ");
				$data .= " , date_released = '".date("Y-m-d H:i")."' ";

				}else{
					$chk = $this->db->query("SELECT * FROM loan_schedules where loan_ID = $id")->num_rows;
					if($chk > 0){
						$thi->db->query("DELETE FROM loan_schedules where loan_ID = $id ");
					}

				}
			}
			if(empty($id)){
				$ref_no = mt_rand(1,99999999);
				$i= 1;

				while($i== 1){
					$check = $this->db->query("SELECT * FROM loans where ref_number ='$ref_no' ")->num_rows;
					if($check > 0){
					$ref_no = mt_rand(1,99999999);
					}else{
						$i = 0;
					}
				}
				$data .= " , ref_no = '$ref_no' ";
			}
			if(empty($id))
			$save = $this->db->query("INSERT INTO loans set ".$data);
			else
			$save = $this->db->query("UPDATE loans set ".$data." where loanID=".$id);
		if($save)
			return 1;
	}
	function delete_loan(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loans where loanID = ".$id);
		if($delete)
			return 1;
	}
	
	function save_payment(){
		extract($_POST);
			$data = " loan_ID = $loan_id ";
			$data .= " , payee = '$payee' ";
			$data .= " , loan_amount = '$amount' ";
			$data .= " , penalty_amount = '$penalty_amount' ";
			$data .= " , overdue = '$overdue' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_repayment set ".$data);
		}else{
			$save = $this->db->query("UPDATE loan_repayment set ".$data." where re_paymentID = ".$id);

		}
		if($save)
			return 1;

	}
	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_repayment where re_paymentID = ".$id);
		if($delete)
			return 1;
	}

}