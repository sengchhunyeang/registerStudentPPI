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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Retrieve form data and sanitize
	$student_name = $conn->real_escape_string($_POST['fname']);
	$gender = $conn->real_escape_string($_POST['sex']);
	$age = intval($_POST['age']);
	$birth_date = $conn->real_escape_string($_POST['date']);
    $current_address = $conn->real_escape_string($_POST['address']);
	$phone_number = $conn->real_escape_string($_POST['phone']);
	$place_birth = $conn->real_escape_string($_POST['State']);
	$skill = $conn->real_escape_string($_POST['major']);
	$level = $conn->real_escape_string($_POST['level']);
	$shift = $conn->real_escape_string($_POST['study-time']);

	// Construct SQL query
	$sql = "INSERT INTO registerStudent (student_name, gender, age, birth_date, current_address, phone_number, place_birth, skill, level, shift) 
            VALUES ('$student_name', '$gender', $age, '$birth_date','$current_address', '$phone_number', '$place_birth', '$skill', '$level', '$shift')";

	// Execute query
	if ($conn->query($sql) === true) {
		echo "<div class='row'>
                <div class='col-sm mt-2'>
                    <div class='alert alert-success text-center ' role='alert'>
                        អ្នកបានបញ្ចូលទិន្នន័យបានជោគជ័យ
                    </div>
                </div>
            </div>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

// Fetch data for the select college
$result = $conn->query("SELECT col_name FROM college");
// Fetch data for the select shift
$result2=$conn->query("SELECT shift_name FROM shift");
$resultSkill=$conn->query("SELECT skill_name FROM skill");
$resultlevel=$conn->query("SELECT level_name FROM level");
$resultGender=$conn->query("SELECT gender_name FROM gender");
$resultProvinces=$conn->query("SELECT province_name FROM provinces");
$resultProvince=$conn->query("SELECT province_name FROM provinces");

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
</head>
<style>
    body{
        font-family: 'Kantumruy Pro', sans-serif;
    }
</style>
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
                <label for="sex">ភេទ</label><br/>
                <select id="sex" class="form-control" name="sex">
					<?php while ($row = $resultGender->fetch_assoc()): ?>
                        <option value="<?= $row['gender_name'] ?>"><?= $row['gender_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="age">អាយុ</label>
                <input type="number" class="form-control" name="age" id="age" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="date">ថ្ងៃ ខែ ឆ្នាំកំណើត</label>
                <input type="date" class="form-control" name="date" id="date" placeholder="" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="province">អាស័យដ្ឋានបច្ចុប្បន្ន</label><br/>
                <select id="province" class="form-control" name="address">
		            <?php
		            while ($row = $resultProvinces->fetch_assoc()){
			            echo '<option value="'.$row['province_name'].'">'.$row['province_name'].'</option>';
		            }
		            ?>
                </select>

            </div>
            <div class="col-md-6 form-group">
                <label for="province">អាស័យដ្ឋានបច្ចុប្បន្ន</label><br/>
                <select id="province" class="form-control" name="State">
		            <?php
		            while ($row = $resultProvince->fetch_assoc()){
			            echo '<option value="'.$row['province_name'].'">'.$row['province_name'].'</option>';
		            }
		            ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="tel">Phone</label>
                <input type="tel" name="phone" class="form-control" id="tel" placeholder="" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="major">មហាវិទ្យាល័យ</label>
                <select id="major" class="form-control" name="major">
					<?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?= $row['col_name'] ?>"><?= $row['col_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="level">មុខជំនាញ</label>
                <select id="level" class="form-control" name="level">
					<?php while ($row = $resultSkill->fetch_assoc()): ?>
                        <option value="<?= $row['skill_name'] ?>"><?= $row['skill_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="study-time">វេនសិក្សា</label>
                <select id="study-time" class="form-control" name="study-time">
					<?php while ($row = $result2->fetch_assoc()): ?>
                        <option value="<?= $row['shift_name'] ?>"><?= $row['shift_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="study-time">កម្រិតថ្នាក់</label>
                <select id="study-time" class="form-control" name="study-time">
					<?php while ($row = $resultlevel->fetch_assoc()): ?>
                        <option value="<?= $row['level_name'] ?>"><?= $row['level_name'] ?></option>
					<?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12 form-group mt-2">
            <button class="btn btn-primary float-right" type="submit">ចុះឈ្មោះ</button>
        </div>
    </form>
</div>
</body>
</html>

