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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['college_name'])) {
	// Retrieve form data and sanitize
	$college_name = $conn->real_escape_string($_POST['college_name']);

	// Check if college name already exists
	$checkQuery = "SELECT college_id FROM Colleges WHERE college_name = '$college_name'";
	$result = $conn->query($checkQuery);

	if ($result->num_rows > 0) {
		$errorMessage = "មហាវិទ្យាល័យមានរួចហើយ !";
	} else {
		// Construct SQL query
		$sql = "INSERT INTO Colleges (college_name) VALUES ('$college_name')";

		// Execute query
		if ($conn->query($sql) === TRUE) {
			$successMessage = "អ្នកបានបញ្ចូលទិន្នន័យបានជោគជ័យ";
		} else {
			$errorMessage = "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
	// Delete college
	$delete_id = intval($_POST['delete_id']);
	$sql = "DELETE FROM Colleges WHERE college_id = $delete_id";

	if ($conn->query($sql) === TRUE) {
		$successMessage = "ការលុបទិន្នន័យបានជោគជ័យ";
	} else {
		$errorMessage = "Error deleting record: " . $conn->error;
	}
}

// Fetch all colleges
$colleges = $conn->query("SELECT college_id, college_name FROM Colleges");

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
	<link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
        }
	</style>
</head>

<body>
<div class="container mt-5">
	<form method="post" action="formInputCollage.php" class="flex justify-center">
		<div class="container h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-9 col-lg-7 col-xl-6">
					<div class="card" style="border-radius: 15px;">
						<div class="card-body p-5">
							<h2 class="text-uppercase text-center mb-5">បញ្ចូលមហាវិទ្យាល័យ</h2>

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
								<label class="form-label" for="college_name">មហាវិទ្យាល៏យ</label>
								<input type="text" id="college_name" name="college_name" class="form-control form-control-lg" required />
							</div>
							<div class="d-flex justify-content-center">
								<button type="submit" class="btn btn-info btn-block btn-lg gradient-custom-4 text-body">បញ្ចូល</button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php if ($colleges->num_rows > 0): ?>
		<div class="col-md" id="collegeTableContainer">
			<h1 class="text-center mt-4 text-sm">មហាវិទ្យាល៏យ</h1>
			<div class="table-responsive">
				<table class="table table-bordered shadow rounded-top m-2 table-sm text-sm table-hover">
					<thead>
					<tr class="bg-info text-center text-white">
						<th>លេងសម្គាល់</th>
						<th>ឈ្មោះមហាវិទ្យាល័យ</th>
						<th>លុប</th>
					</tr>
					</thead>
					<tbody id="collegeTableBody">
					<?php while ($row = $colleges->fetch_assoc()): ?>
						<tr class="text-center">
							<td><?php echo $row['college_id']; ?></td>
							<td><?php echo $row['college_name']; ?></td>
							<td>
								<form method="post" action="formInputCollage.php" style="display:inline;">
									<input type="hidden" name="delete_id" value="<?php echo $row['college_id']; ?>">
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
