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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Check if all required fields are set
	$required_fields = ['fname', 'sex', 'age', 'date', 'address', 'phone_number', 'State', 'major', 'level', 'study-time', 'college', 'year'];

	$missing_fields = array_filter($required_fields, function($field) {
		return !isset($_POST[$field]) || empty(trim($_POST[$field]));
	});

	if (!empty($missing_fields)) {
		echo "<div class='alert alert-danger text-center' role='alert'>
                Please fill out all required fields.
              </div>";
	} else {
		// Retrieve form data and sanitize
		$student_name = $conn->real_escape_string($_POST['fname']);
		$gender = $conn->real_escape_string($_POST['sex']);
		$age = intval($_POST['age']);
		$birth_date = $conn->real_escape_string($_POST['date']);
		$current_address = $conn->real_escape_string($_POST['address']);
		$phone_number = $conn->real_escape_string($_POST['phone_number']);
		$place_of_birth = $conn->real_escape_string($_POST['State']);
		$skill = $conn->real_escape_string($_POST['major']);
		$level = $conn->real_escape_string($_POST['level']);
		$shift = $conn->real_escape_string($_POST['study-time']);
		$shift_id = intval($_POST['study-time']);
		$college_id = intval($_POST['college']);
		$year_id = intval($_POST['year']);

		// Construct SQL query using prepared statement
		$sql = "INSERT INTO Students (student_name, gender, age, birth_date, current_address, place_of_birth, skill, level, shift, phone_number, shift_id, college_id, year_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $conn->prepare($sql);
		if ($stmt) {
			$stmt->bind_param("ssissssssiiii", $student_name, $gender, $age, $birth_date, $current_address, $place_of_birth, $skill, $level, $shift, $phone_number, $shift_id, $college_id, $year_id);
			if ($stmt->execute()) {
				echo "<div class='row'>
                        <div class='col-sm mt-2'>
                            <div class='alert alert-success text-center' role='alert'>
                                បញ្ចូលទិន្នន័យបានជោជ័យ
                            </div>
                        </div>
                      </div>";
			} else {
				echo "Error: " . $stmt->error;
			}
			$stmt->close();
		} else {
			echo "Error: " . $conn->error;
		}
	}
}

// Fetch data for the select shift
$resultShifts = $conn->query("SELECT shift_id, shift_name FROM Shifts");

// Fetch data for the select provinces (for current and birth address)
$resultProvinces = $conn->query("SELECT province_name FROM Provinces");

// Fetch data for the select skills
$resultSkills = $conn->query("SELECT skill_id, skill_name FROM Skills");

// Fetch data for the select level
$resultLevels = $conn->query("SELECT level_id, level_name FROM Levels");

// Fetch data for the select gender
$resultGenders = $conn->query("SELECT gender_id, gender_name FROM Genders");

// Fetch data for the select colleges
$resultColleges = $conn->query("SELECT college_id, college_name FROM Colleges");

// Fetch data for the select years
$resultYears = $conn->query("SELECT year_id, year_name FROM years");

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
    <form method="post">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h1>ការចុះឈ្មោះរបស់សិស្ស</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name-f">ឈ្មោះសិស្ស</label>
                <input type="text" class="form-control" name="fname" id="name-f" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="sex">ភេទ</label><br />
                <select id="sex" class="form-control" name="sex">
					<?php while ($row = $resultGenders->fetch_assoc()): ?>
                        <option value="<?= $row['gender_name'] ?>"><?= $row['gender_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="age">អាយុ</label>
                <input type="text" class="form-control" name="age" id="age" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="date">ថ្ងៃ ខែ ឆ្នាំកំណើត</label>
                <input type="date" class="form-control" name="date" id="date" placeholder="" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="address">អាស័យដ្ឋានកំណើត</label><br />
                <select id="address" class="form-control" name="address">
					<?php while ($row = $resultProvinces->fetch_assoc()): ?>
                        <option value="<?= $row['province_name'] ?>"><?= $row['province_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="State">អាស័យដ្ឋានបច្ចុប្បន្ន (បច្ចុប្បន្ន)</label><br />
                <select id="State" class="form-control" name="State">
					<?php $resultProvinces->data_seek(0); // Reset pointer to fetch provinces again ?>
					<?php while ($row = $resultProvinces->fetch_assoc()): ?>
                        <option value="<?= $row['province_name'] ?>"><?= $row['province_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="major">ជំនាញ</label>
                <select id="major" class="form-control" name="major">
					<?php while ($row = $resultSkills->fetch_assoc()): ?>
                        <option value="<?= $row['skill_name'] ?>"><?= $row['skill_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="level">កម្រិតសិក្សា</label>
                <select id="level" class="form-control" name="level">
					<?php while ($row = $resultLevels->fetch_assoc()): ?>
                        <option value="<?= $row['level_name'] ?>"><?= $row['level_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="study-time">វេនសិក្សា</label>
                <select id="study-time" class="form-control" name="study-time">
					<?php $resultShifts->data_seek(0); // Reset pointer to fetch shifts again ?>
					<?php while ($row = $resultShifts->fetch_assoc()): ?>
                        <option value="<?= $row['shift_id'] ?>"><?= $row['shift_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="college">មហាវិទ្យាល័យ</label>
                <select id="college" class="form-control" name="college">
					<?php while ($row = $resultColleges->fetch_assoc()): ?>
                        <option value="<?= $row['college_id'] ?>"><?= $row['college_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="phone_number">លេខទូរស័ព្ទ</label>
                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="year">ឆ្នាំសិក្សា</label>
                <select id="year" class="form-control" name="year">
					<?php while ($row = $resultYears->fetch_assoc()): ?>
                        <option value="<?= $row['year_id'] ?>"><?= $row['year_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group mt-2">
                <button class="btn btn-info float-right" type="submit">ចុះឈ្មោះ</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
