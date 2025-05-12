<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "tours"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$search = "";
$state = "";
$budget = "";
$interest = "";

// Fetch data based on filters
$sql = "SELECT * FROM tourist_places WHERE 1";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'] ?? '';
    $state = $_POST['state'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $interest = $_POST['interest'] ?? '';

    // Apply filters dynamically
    if (!empty($search)) {
        $sql .= " AND (name LIKE '%$search%' OR state LIKE '%$search%')";
    }
    if (!empty($state)) {
        $sql .= " AND state = '$state'";
    }
    if (!empty($budget)) {
        $sql .= " AND budget <= '$budget'";
    }
    if (!empty($interest)) {
        $sql .= " AND interest = '$interest'";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Place Search</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        input, select { padding: 8px; margin: 5px; }
        input[type="submit"] { cursor: pointer; }
a {text-decoration:none;color:black;background-color:yellow;padding:10px;font-size:20px;}
h1 {border:none;color:white;background-color:blue;padding:10px;font-size:25px;}
h2 {color:black;font-size:23px; background-color:yellow;padding:10px; font-weight: bold;}
h5 {color:white;font-size:25px;font-weight: bold;}
h4 {color:navy;font-size:20px;}
h4 label {color:darkgreen;font-size:21px;}

form {background: white;padding: 20px;border-radius: 8px;box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);display: inline-block;margin-top: 20px;}
input, select {width: 200px;padding: 10px;margin: 10px;border: 1px solid #ccc;border-radius: 5px;font-size: 16px;}
input[type="submit"] {background: #28a745;color: white;border: none;padding: 12px 20px;font-size: 18px;cursor: pointer;
    border-radius: 6px;transition: 0.3s;}
input[type="submit"]:hover {background: #218838;}
body {font-family: Arial, sans-serif;background-image:url("b.png");margin: 0;padding: 20px;text-align: center;}
.places-container {display: grid;grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));gap: 20px;padding: 20px;max-width: 1200px;margin: auto;}
.place-card {background: white;border-radius: 10px;padding: 20px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
transition: transform 0.3s ease, box-shadow 0.3s ease;text-align: left;}
.place-card:hover {transform: scale(1.05);box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);}
.place-card h3 {color:red;margin-bottom: 8px;font-size:25px;}

</style>
</head>
<body>
<center><h1>  Road Map For Tourist Places </h1>
<h2><a href= "homepage2.html"> Home </a> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<a href="Places.html"> Places </a>
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <a href= "ideas.php">Ideas</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
 <a href="travellers.php"> Companion </a> </h2> 
<h5>Travel Ideas </h5>
<center>

<form method="post" action="">
    <input type="text" name="search" placeholder="Place Name" value="<?php echo $search; ?>">

    <select name="state">
        <option value="">Select State</option>
        <option value="Tamil Nadu" <?php if ($state == "Tamil Nadu") echo "selected"; ?>>Tamil Nadu</option>
        <option value="Kerala" <?php if ($state == "Kerala") echo "selected"; ?>>Kerala</option>
        <option value="Karnataka" <?php if ($state == "Karnataka") echo "selected"; ?>>Karnataka</option>        
        <option value="Goa" <?php if ($state == "Goa") echo "selected"; ?>>Goa</option>
    </select>
  
    <select name="budget">
        <option value="">Select Budget</option>
        <?php for ($i = 1000; $i <= 15000; $i += 1000) { ?>
            <option value="<?php echo $i; ?>" <?php if ($budget == $i) echo "selected"; ?>>₹<?php echo $i; ?></option>
        <?php } ?>
    </select>

  <select name="interest">
    <option value="">Select Interest</option>
    <option value="Mountain" <?php if ($interest == "Mountain") echo "selected"; ?>>Mountains</option>
    <option value="City" <?php if ($interest == "City") echo "selected"; ?>>City</option>
</select>

    <input type="submit" value="Search">
</form>

<div class="places-container">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="place-card">
<center>
            <h3><?php echo $row['name']; ?></h3>
            <h4><label>State:</label> <?php echo $row['state']; ?></h4>
            <h4><label>Budget:</label> ₹<?php echo $row['budget']; ?></h4>
            <h4><label>For Days :</label> <?php echo $row['days']; ?></h4>
           <h4><label>Interest:</label> <?php echo $row['interest']; ?></h4>
           <h4><label>Places:</label> <br><?php echo $row['places']; ?></h4>
<center>
        </div>
    <?php } ?>
</div>
</center>
</body>
</html>

<?php
$conn->close();
?>
