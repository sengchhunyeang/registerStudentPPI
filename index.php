<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="images/ppiImage.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
	        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
	        crossorigin="anonymous"></script>
	<title>Login</title>
</head>
<body>

<section class="h-100">
	<div class="container h-100">
		<div class="row justify-content-sm-center h-100">
			<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
				<div class="text-center my-5">
					<img src="images/ppiImage.png" alt="logo" width="100">
				</div>
				<div class="card shadow-sm p-3 mb-5 bg-body rounded">
					<div class="card-body p-5">
						<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
						<form method="POST" class="needs-validation" novalidate autocomplete="off">
							<div class="mb-3">
								<label class="mb-2 text-muted" for="email">Username</label>
								<input id="email" type="email" class="form-control" name="email" required autofocus>
								<div class="invalid-feedback">
									Email is invalid
								</div>
							</div>
							<div class="mb-3">
								<label for="password">Password</label>
								<input id="password" type="password" class="form-control" name="password" required>
								<div class="invalid-feedback">
									Password is required
								</div>
							</div>
							<div>
								<button type="submit" class="btn btn-info" name="btn-login" data-bs-toggle="modal" data-bs-target="#myModal">Login</button>
							</div>
						</form>
						<?php
						if (isset($_POST['btn-login'])) {
							$username = $_POST['email'];
							$password = $_POST['password'];
							if ($username == "admin" && $password == "123") {
								header('Location: form.php');
								exit;
							} elseif($username!="admin") {
								echo '<script type="text/javascript">alert("wrong username ");</script>';
							}else{
								echo '<script type="text/javascript">alert("wrong password ");</script>';
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

</body>
</html>
