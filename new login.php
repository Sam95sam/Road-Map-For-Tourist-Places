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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } {
        // Insert in the database
        $stmt = $conn->prepare("INSERT INTO tourist (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        
        if ($stmt->execute()) {
            $_SESSION['user'] = $email;
            header("Location: homepage2.html"); 
            exit();
        } 
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Login Page</title>
    <style>
body {background-image:url("b.png");}
a {text-decoration:none;margin:20px;text-color:blue;color:black;border:2px;}
h1{border:none;color:white;background-color:blue;padding:15px;
font-size:25px;}
h2{border:2px;color:black;background-color:yellow;padding:8px;
font-size:22px;}
h3 {color:white;font-size:22px;}
h4 { color:white;font-size:22px;}
h5 { color:yellow;font-size:20px;}
button{background-color:purple;color:white;font-size:18px;
border:5px;padding:5px; font-weight:bold;}
</style>
</head>
<body>
<center>
<h1>  Road Map For Tourist Places </h1>
    <div class="login-container">
        <h3> New Login Page </h3>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="" method="POST">
         <h4> 
            <input type="text" id="name" name="name"  placeholder="Enter Your Name" required><br><br>
        <input type="email" id="email" name="email" placeholder="Enter Your Email ID "  required><br><br>
        <input type="password" id="password" name="password"  placeholder="Create Your password " required>
         <input type="password" id="confirm_password" name="confirm_password"   placeholder="Confirm Your Password " required>
       
</h4>
        <button type="submit">&emsp;New Login&emsp;</button>
<br>
 <a href ="login.php"><h5>Already Have An Account !! </h5></a>
    </form>
</div>
</center>
</body>
</html>
