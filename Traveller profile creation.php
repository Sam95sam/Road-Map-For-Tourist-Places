<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "tours";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $present_location = $_POST['present_location'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $travel_destination = $_POST['travel_destination'];
    $contact_details = $_POST['contact_details'];
    $mode_of_transport = $_POST['mode_of_transport'];
    $travel_date = $_POST['travel_date_from'];
    $return_date = $_POST['to_date'];
    $additional_info = $_POST['additional_info'];

    // Handle file upload
    $target_dir = "C:\wamp\www\paste"; // Folder where images will be stored
    $photo = $target_dir . basename($_FILES["photo"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $uploadOk = 0;
    }

    // Move uploaded file to the target directory
    if ($uploadOk && move_uploaded_file($_FILES["photo"]["tmp_name"], $photo)) {
        // Insert data into the database
        $sql = "INSERT INTO travellers (name, present_location, photo, age, gender, travel_destination, contact_details, mode_of_transport, travel_date_from, to_date, additional_info)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssssss", $name, $present_location, $photo, $age, $gender, $travel_destination, $contact_details, $mode_of_transport, $travel_date, $return_date, $additional_info);
        
        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        header("Location: travellers.php");
        exit();

        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Road Map For Tourist Places</title>
<style>
body {color:black;font-weight:bold;background-image:url("bg2.jpg");background-size:1400px 1000px;}
a {text-decoration:none;border:none;color:black;background-color:yellow;padding:10px;font-size:22px;}
h2 {color:white;font-size:24px;background-color:yellow;padding:10px;}
h1 {border:none;color:white;background-color:blue;padding:10px;font-size:25px;}
h3 {color:purple;font-size:24px;padding:10px;}
h4 {color:maroon;font-size:20px;padding:10px;}
button {border:2px;color:white;background-color:green;padding:8px;font-size:20px;}
</style>
</head>
<body>
<center>

<form method="post" action="" enctype="multipart/form-data">
<h1>Road Map For Tourist Places</h1>
<h2><a href= "homepage2.html"> Home </a> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<a href="Places.html"> Places </a>
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <a href= "ideas.php">Ideas</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
 <a href="travellers.php"> Companion</a> </h2>
<h3>Create Your Profile </h3>
<h4>
    Name: <input type="text" name="name" required>&nbsp;&nbsp;&nbsp;&nbsp;
    Present Location: <input type="text" name="present_location" required>&nbsp;&nbsp;&nbsp;&nbsp;
    Age: <input type="number" name="age" required>&nbsp;&nbsp;&nbsp;&nbsp;
    Gender: 
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;
    Travel Destination: <input type="text" name="travel_destination" required>&nbsp;&nbsp;&nbsp;&nbsp;
        Mode of Transport: 
    <select name="mode_of_transport" required>
        <option value="Bike">Bike</option>
        <option value="Car">Car</option>
        <option value="Bus">Bus</option>
        <option value="Train">Train</option>
        <option value="Flight">Flight</option>
           <option value="Other">Other</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;
    Travel Date: <input type="date" name="travel_date_from">&nbsp;&nbsp;&nbsp;&nbsp;
    Return Date: <input type="date" name="to_date"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;
   Contact Details: <input type="text" name="contact_details" required>&nbsp;&nbsp;&nbsp;&nbsp;
    Additional Information: <input type= "text" name="additional_info"></input><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;
    Upload Photo: <input type="file" name="photo"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Upload" >
</h4>
</form>	
</center>
</body>
</html>
