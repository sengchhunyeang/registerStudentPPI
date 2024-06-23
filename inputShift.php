<?php
// Database connection parameters
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

$successMessage = '';
$errorMessage = '';

// Handle form submission to insert new shift
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shift_name'])) {
	// Retrieve and sanitize form data
	$shift_name = $conn->real_escape_string($_POST['shift_name']);

	// Check if shift name already exists
	$checkQuery = "SELECT shift_id FROM Shifts WHERE shift_name = '$shift_name'";
	$result = $conn->query($checkQuery);

	if ($result->num_rows > 0) {
		$errorMessage = "មានវេននេះហើយ !";
	} else {
		// Construct SQL query to insert new shift
		$sql = "INSERT INTO Shifts (shift_name) VALUES ('$shift_name')";

		// Execute query
		if ($conn->query($sql) === true) {
			$successMessage = "អ្នកបានបញ្ចូលវេនសិក្សាបានជោគជ័យ";

			// Retrieve updated shifts list after insertion
			$shifts = $conn->query("SELECT shift_id, shift_name FROM Shifts");
		} else {
			$errorMessage = "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

// Handle deletion of shift
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_shift_id'])) {
	$delete_shift_id = intval($_POST['delete_shift_id']);
	$sql = "DELETE FROM Shifts WHERE shift_id = $delete_shift_id";

	if ($conn->query($sql) === true) {
		$successMessage = "ការលុបទិន្នន័យបានជោគជ័យ";
	} else {
		$errorMessage = "Error deleting record: " . $conn->error;
	}
}

// Fetch all shifts
if (!isset($shifts)) {
	$shifts = $conn->query("SELECT shift_id, shift_name FROM Shifts");
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="km">

<head>
	<meta charset="UTF-8">
	<title>ការចុះឈ្មោះរបស់សិស្ស</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap"
	      rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
        }
	</style>
</head>

<body>
<div class="container mt-5">
	<form method="post" action="formInputShift.php" class="flex justify-center">
		<div class="container h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-9 col-lg-7 col-xl-6">
					<div class="card" style="border-radius: 15px;">
						<div class="card-body p-5">
							<h2 class="text-uppercase text-center mb-5">បញ្ចូលវេនសិក្សា</h2>

							<?php if ($successMessage): ?>
								<div class="alert alert-success text-center" role="alert">
									<?php echo $successMessage; ?>
								</div>
							<?php endif; ?>
							<?php if ($errorMessage): ?>
								<div class="alert alert-danger text-center" role="alert">
									<?php echo $errorMessage; ?>
								</div>
							<?php endif; ?>

							<div data-mdb-input-init class="form-outline mb-4">
								<label class="form-label" for="shift_name">វេនសិក្សា</label>
								<input type="text" id="shift_name" name="shift_name"
								       class="form-control form-control-lg" required/>
							</div>
							<div class="d-flex justify-content-center">
								<button type="submit"
								        class="btn btn-info btn-block btn-lg gradient-custom-4 text-body">បញ្ចូល
								</button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<?php if ($shifts->num_rows > 0): ?>
		<div class="col-md" id="shiftTableContainer">
			<h1 class="text-center mt-4 text-sm">វេនសិក្សា</h1>
			<div class="table-responsive">
				<table class="table table-bordered shadow rounded-top m-2 table-sm text-sm table-hover">
					<thead>
					<tr class="bg-info text-center text-white">
						<th>លេខសម្គាល់</th>
						<th>ឈ្មោះវេនសិក្សា</th>
						<th>លុប</th>
					</tr>
					</thead>
					<tbody id="shiftTableBody">
					<?php while ($row = $shifts->fetch_assoc()): ?>
						<tr class="text-center">
							<td><?php echo $row['shift_id']; ?></td>
							<td><?php echo $row['shift_name']; ?></td>
							<td>
								<form method="post" action="formInputShift.php" style="display:inline;">
									<input type="hidden" name="delete_shift_id" value="<?php echo $row['shift_id']; ?>">
									<button type="submit" class="btn btn-danger btn-sm">លុប</button>
								</form>
							</td>
						</tr>
					<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>

</div>

</body>

</html>
