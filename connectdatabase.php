<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "PPI";

// Connection
$conn = new mysqli($servername,
	$username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: "
		. $conn->connect_error);
}
echo "Connected successfully";
$sql = "SELECT student_name, gender, age, birth_date, current_address, phone_number, place_birth, skill, level, shift FROM registerStudent";
$result = $conn->query($sql);
if (!$result) {
	die("Query failed: " . $conn->error);
}
?>
<?php

