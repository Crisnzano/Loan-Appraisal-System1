<?php
session_start();
require_once("db_connect.php");


$type="";
if (isset($_POST["submit"]))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    

   $query = "SELECT * FROM roles where username='$username' AND password = '$password'";

   $result = mysqli_query($conn,$query);

   if(mysqli_num_rows($result) > 0)
   {

    while($row = mysqli_fetch_assoc($result))
    { 
        if($row["type"] == 1){
            $_SESSION['username'] = $row["username"];
            $_SESSION['role'] = $row["type"];
        
            header('location: index.php?page=home');
        }

         else if($row["type"] == 2){
            $_SESSION['username'] = $row["username"];
            $_SESSION['role'] = $row["type"];
           
            header('location: Client.php');}

         else if($row["type"] == 3){
            $_SESSION['username'] = $row["username"];
            $_SESSION['role'] = $row["type"];
            
            header('location: Manager.php ');}

    }

   }
   else
   {
    header("");

   }
}
?>