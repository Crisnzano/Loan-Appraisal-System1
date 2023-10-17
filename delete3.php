<?php
    include('./db_connect.php');
    if(isset($_GET['Del']))
    {
        $roleID = $_GET['Del'];
        $query = " DELETE from roles where roleID ='".$roleID."'";
        $result = mysqli_query($conn,$query);


        if($result)
        {
            header("location: index.php?page=users");
        }
        else{
            echo 'Please Check Your Query';
        }
    }
?>