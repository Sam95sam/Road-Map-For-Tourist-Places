<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "tours";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM tourist WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['email'] = $email;
        header("Location: homepage2.html");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
<style>
body {background-image:url("b.png");}
a {text-decoration:none;margin:20px;text-color:blue;color:black;border:2px;}
h1 {border:none;color:white;background-color:blue;padding:15px;font-size:25px;}
h2 {border:2px;color:black;background-color:yellow;padding:8px;font-size:22px;}
h3 {color:white;font-size:22px;}
h4 { color:white;font-size:20px;}

h5 { color:yellow;font-size:20px;}
button { background-color:purple;color:white;font-size:18px;border:5px;padding:5px; font-weight:bold;}
    </style>
</head>
<body>
<center>
<h1>  Road Map For Tourist Places </h1>
    <h3>Login Page</h3>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="" method="POST">
      <h4>   <label>Email ID</label>
        <input type="email" name="email" placeholder="Email" required><br><br>
      <label>Password </label>  
      <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login">&emsp;Login&emsp;</button>
 </h3>
 <a href ="new login.php"><h5>To Create An Account !! </h5></a>
  
<center>
    </form>
</body>
</html>
