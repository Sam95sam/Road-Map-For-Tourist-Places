<?php
include("connection.php");
{
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = "INSERT INTO tourist VALUES('$name','$email','$password')";
$data = mysqli_query($db_connect,$query);

if($data)
{
    echo"welcome to Travel"  ;
}
else
{
   echo"Your New Login Is failled. Try Again";   
}
}
?>