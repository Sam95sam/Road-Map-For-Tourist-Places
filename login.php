<?php
include("connection.php");
{
$email = $_POST['email'];
$password = $_POST['password'];

$email  = stripcslashes($email);
$password = stripcslashes($password);

$email = mysqli_real_escape_string($db_connect,$email);
$password = mysqli_real_escape_string($db_connect,$password);

$query = "select * FROM tourist WHERE email ='$email' && password = '$password'";
$data = mysqli_query($db_connect,$query);

$row = mysqli_fetch_array($data,MYSQLI_ASSOC);
$count = mysqli_num_rows($data);

if($count == 1)
{
echo" Welcome Back To Here .!. ";
}
else
{
echo" Please, Try Again ";
}
}
?>