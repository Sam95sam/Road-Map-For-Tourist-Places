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

// Fetch filter values from URL parameters
$destination_filter = isset($_GET['destination']) ? $_GET['destination'] : "";
$transport_filter = isset($_GET['transport']) ? $_GET['transport'] : "";

// SQL Query with filters
$sql = "SELECT * FROM travellers WHERE 1";
if (!empty($destination_filter)) {
    $sql .= " AND travel_destination = '$destination_filter'";
}
if (!empty($transport_filter)) {
    $sql .= " AND mode_of_transport = '$transport_filter'";
}

$result = $conn->query($sql);

// Fetch distinct destinations and transport modes for the filter dropdowns
$destinations = $conn->query("SELECT DISTINCT travel_destination FROM travellers");
$transports = $conn->query("SELECT DISTINCT mode_of_transport FROM travellers");

$imagepath = "Select photo from travellers";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveler Profiles</title>

<style>
body {color:black;font-size:18px;padding: 20px; text-align: center;}
a {text-decoration:none;border:none;color:black;background-color:yellow;padding:10px;font-size:20px;}
h2 {color:white;font-size:24px;background-color:yellow;padding:10px;}
h1 {border:none;color:white;background-color:blue;padding:10px;font-size:25px;}
h3 {color:white;font-size:24px;}
.card-container {display: flex;flex-wrap: wrap;justify-content: center;gap: 20px;margin-top: 20px;}
.card {background: white; border-radius: 12px;box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);width: 320px;padding: 20px; text-align: center; transition: 
           transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;}
.card:hover {transform: translateY(-5px);box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); }
.card img { width: 100%;  height: 200px; object-fit: cover;border-radius: 10px; border: 3px solid #007bff;}
.card h3 { margin: 15px 0 10px; color: #007bff;   font-size: 1.4em;}
.card p {margin: 5px 0;color: #555;  font-size: 0.95em;}
.contact-btn {display: inline-block; width: 100%;  padding: 12px;margin-top: 12px;background: #007bff; color: white; text-align: center;  border-radius: 6px;
                         text-decoration: none; font-weight: bold; transition: background 0.3s ease-in-out;}
.contact-btn:hover { background: #0056b3;}
.filter-container {margin-bottom: 20px;}
select {padding: 8px;font-size: 16px;margin: 5px;}
</style>

<script>
function applyFilter() {
    var destination = document.getElementById("destination").value;
    var transport = document.getElementById("transport").value;
    window.location.href = "?destination=" + destination + "&transport=" + transport;
}
</script>

</head>
<body>
<h1> Road Map For Tourist Places </h1>
<h2><a href= "homepage2.html"> Home </a> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<a href="Places.html"> Places </a>
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <a href= "ideas.php">Ideas</a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
<a href="companion.php"> Create Profile</a> </h2> 

<h3>Traveller Profiles</h3>

<!-- Filter Section -->
<div class="filter-container">
    <label for="destination">Destination</label>
    <select id="destination" onchange="applyFilter()">
        <option value="">All</option>
        <?php while ($row = $destinations->fetch_assoc()) { ?>
            <option value="<?php echo $row['travel_destination']; ?>" <?php if ($destination_filter == $row['travel_destination']) echo "selected"; ?>>
                <?php echo $row['travel_destination']; ?>
            </option>
        <?php } ?>
    </select>

    <label for="transport">Mode of Transport</label>
    <select id="transport" onchange="applyFilter()">
        <option value="">All</option>
        <?php while ($row = $transports->fetch_assoc()) { ?>
            <option value="<?php echo $row['mode_of_transport']; ?>" <?php if ($transport_filter == $row['mode_of_transport']) echo "selected"; ?>>
                <?php echo $row['mode_of_transport']; ?>
            </option>
        <?php } ?>
    </select>
</div>

<!-- Traveler Profiles -->
<div class="card-container">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
<img src="<?php echo htmlspecialchars($row['photo']); ?>">

<h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($row['present_location']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($row['age']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($row['travel_destination']); ?></p>
            <p><strong>Transport:</strong> <?php echo htmlspecialchars($row['mode_of_transport']); ?></p>
            <p><strong>Travel Date:</strong> <?php echo htmlspecialchars($row['travel_date_from']); ?></p>
            <p><strong>Return Date:</strong> <?php echo htmlspecialchars($row['to_date']); ?></p>
            <p><strong>Mentions:</strong> <?php echo htmlspecialchars($row['additional_info']); ?></p>
            <a href="mailto:<?php echo htmlspecialchars($row['contact_details']); ?>" class="contact-btn">Contact</a>
        </div>
    <?php } ?>
</div>

</body>
</html>

<?php $conn->close(); ?>

