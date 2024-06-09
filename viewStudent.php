<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/ppiImage.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
            background: #f1f1f1;
        }

        label {
            font-weight: 600;
            color: #666;
        }
    </style>
</head>
<body>
<?php
include 'navbar.php';
?>

<?php
// Database credentials
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "PPI";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Check if delete button is clicked and if student ID is provided
	if(isset($_POST['delete']) && isset($_POST['student_id'])) {
		$id = $conn->real_escape_string($_POST['student_id']);

		// SQL query to delete the item
		$sql = "DELETE FROM registerStudent WHERE student_id = '$id'";

		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
			// Redirect to the same page after deletion
			header("Location: ".$_SERVER['PHP_SELF']);
			exit;
		} else {
			echo "Error deleting record: " . $conn->error;
		}
	}
}

// SQL query to get data from registerStudent table
$sql = "SELECT student_id, student_name, gender, age, birth_date, current_address, phone_number, place_birth, skill, level, shift FROM registerStudent";
$result = $conn->query($sql);

if (!$result) {
	die("Query failed: " . $conn->error);
}
?>


<div class="container-fluid">
    <div class="row">
		<?php include 'sidebar.php'; ?>
        <div class="col-md">
            <h1 class="text-center mt-2">តារាងមើលឈ្មោះសិស្ស</h1>
            <div class="table-responsive">
                <table class="table table-bordered shadow rounded-top m-2 table-sm text-sm table-hover">
                    <thead>
                    <tr class="bg-info text-center text-white">
                        <th>លេខរៀង</th>
                        <th>ឈ្មោះសិស្ស</th>
                        <th>ភេទ</th>
                        <th>អាយុ</th>
                        <th>ថ្ងៃកំណើត</th>
                        <th>អាស័យដ្ឋានបច្ចុប្បន្ន</th>
                        <th>លេខទូរស័ព្ទ</th>
                        <th>ទីកន្លែងកំណើត</th>
                        <th>ជំនាញ</th>
                        <th>កម្រិត</th>
                        <th>វេនសិក្សា</th>
                        <th>សកម្មភាព</th> <!-- New column for delete button -->
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if ($result->num_rows > 0) {
						// Output data of each row
						while ($row = $result->fetch_assoc()) {
							echo "<tr>
                                    <td>" . htmlspecialchars($row["student_id"]) . "</td>
                                    <td>" . htmlspecialchars($row["student_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["gender"]) . "</td>
                                    <td>" . htmlspecialchars($row["age"]) . "</td>
                                    <td>" . htmlspecialchars($row["birth_date"]) . "</td>
                                    <td>" . htmlspecialchars($row["current_address"]) . "</td>
                                    <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["place_birth"]) . "</td>
                                    <td>" . htmlspecialchars($row["skill"]) . "</td>
                                    <td>" . htmlspecialchars($row["level"]) . "</td>
                                    <td>" . htmlspecialchars($row["shift"]) . "</td>
                                    <td>
                                        <form method='post'>
                                            <input type='hidden' name='student_id' value='" . htmlspecialchars($row["student_id"]) . "'>
                                            <button type='submit' class='btn btn-outline-danger btn-sm' name='delete' style='width: 100px;'>លុប</button>

                                        </form>
                                    </td>
                                </tr>";
						}
					} else {
						echo "<tr><td colspan='11'>No results found</td></tr>";
					}
					?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZU
