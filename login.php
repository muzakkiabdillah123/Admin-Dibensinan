<?php
session_start();
require_once "vendor/autoload.php";

use App\Models\Firestore;

$db = new Firestore();
$collection = $db->setCollectionName("penggunaHokya");

if (isset($_SESSION["login"])) {
	header("Location: index.php");
	exit;
}

// Apakah submit sudah di klik
if (isset($_POST["login"])) {
	// Mengambil data email dan password dari _POST
	$email = $_POST["email"];
	$password = $_POST["password"];

	$_SESSION['email'] = $_POST['email'];

	// cek apakah email ada di database
	$collection->checkLogin($email, "email");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Log-in Dibensinan</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
	<link rel="shortcut icon" href="favicon.ico">

	<!-- FontAwesome JS-->
	<script defer src="assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- App CSS -->
	<link id="theme-style" rel="stylesheet" href="dist/css/LoginRegister.css">

</head>

<body class="app app-login p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding mb-4">
						<div class="app-logo"><img class="logo-icon me-2" src="images/LogoBulat.png" alt="logo">
						</div>
					</div>
					<h2 class="auth-heading text-center mb-5">Log in</h2>
					<div class="auth-form-container text-start">
						<form method="post" action="" class="auth-form login-form">
							<div class="email mb-3">
								<!-- <label class="sr-only" for="email"></label> -->
								<input id="email" name="email" type="text" class="form-control email" placeholder="Email" required="required">
							</div>
							<!--//form-group-->
							<div class="password mb-3">
								<!-- <label class="sr-only" for="password"></label> -->
								<input id="password" name="password" type="password" class="form-control password" placeholder="Password" required="required">
								<!--//extra-->
							</div>
							<!--//form-group-->
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto" name="login">Log In</button>
								<!-- <button type="submit" class="btn-login w-100 theme-btn mx-auto">Log In</button> -->
							</div>
						</form>
						<div class="auth-option text-center pt-5">Mitra in Dibensinan?<a class="text-link" href="Mitra/login_mitra.php">Click Here</a>.</div>
					</div>
					<!--//auth-form-container-->

				</div>
				<!--//auth-body-->

			</div>
			<!--//flex-column-->
		</div>
		<!--//auth-main-col-->
		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
				<div class="d-flex flex-column align-content-end h-100">
					<div class="h-100"></div>
				</div>
			</div>
			<!--//auth-background-overlay-->
		</div>
		<!--//auth-background-col-->

	</div>
	<!--//row-->


</body>

</html>