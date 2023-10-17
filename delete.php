<?php
    include('./db_connect.php');
    if(isset($_GET['Del']))
    {
        $StaffID = $_GET['Del'];
        $query = " DELETE from staff where staffID ='".$StaffID."'";
        $result = mysqli_query($conn,$query);


        if($result)
        {
            header("location:reports3.php");
        }
        else{
            echo 'Please Check Your Query';
        }
    }
?>