<?php
session_start();

require_once "../vendor/autoload.php";

use App\Models\Firestore;

$db = new Firestore();
$mitra = $db->setCollectionName("mitra");

if (isset($_POST["daftar_mitra"])) {
	// Mengambil data email dan password dari _POST
	$namaMitra = $_POST["namaMitra"];
	$emailMitra = $_POST["emailMitra"];
	$waMitra = $_POST["waMitra"];
	$lokasiMitra = $_POST["lokasiMitra"];
	$stokPertamax = $_POST["stokPertamax"];
	$stokPertalite = $_POST["stokPertalite"];
	$jenisBensin = ['Pertalite', 'Pertamax'];

	// add data to database
	$idMitra = $mitra->newDocument([
		"namaMitra" => $namaMitra,
		"emailMitra" => $emailMitra,
		"waMitra" => $waMitra,
		"lokasiMitra" => $lokasiMitra,
		"stokPertamax" => $stokPertamax,
		"stokPertalite" => $stokPertalite,
		"jenisBensin" => $jenisBensin,
	]);

	// alert
	echo "<script>
            alert('Anda Berhasil Daftar');
            document.location.href = 'login_mitra.php';
        </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sign-Up Dibensinan</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
	<link rel="shortcut icon" href="favicon.ico">

	<!-- FontAwesome JS-->
	<script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- App CSS -->
	<link id="theme-style" rel="stylesheet" href="../dist/css/LoginRegister.css">


</head>

<body class="app app-signup p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding pt-0 mb-0">
						<div class="app-logo pt-0">
							<img class="logo-icon me-2" src="../images/LogoBulat.png" alt="logo">
						</div>
					</div>

					<div class="auth-form-container text-start mx-auto">
						<form method="post" action="" class="auth-form auth-signup-form">
							<div class="email mb-2">
								<!-- <label class="sr-only" for="emailMitra">Your Name</label> -->
								<input id="namaMitra" name="namaMitra" type="text" class="form-control namaMitra" placeholder="Nama Mitra" required="required">
							</div>
							<div class="email mb-2">
								<!-- <label class="sr-only" for="emailMitra">Your Email</label> -->
								<input id="emailMitra" name="emailMitra" type="email" class="form-control emailMitra" placeholder="Email" required="required">
							</div>
							<div class="password mb-2">
								<!-- <label class="sr-only" for="passwordMitra">Password</label> -->
								<input id="passwordMitra" name="passwordMitra" type="password" class="form-control passwordMitra" placeholder="Buat Kata Sandi" required="required">
							</div>
							<div class="email mb-2">
								<!-- <label class="sr-only" for="emailMitra">Your Name</label> -->
								<input id="waMitra" name="waMitra" type="text" class="form-control waMitra" placeholder="Nomor WA" required="required">
							</div>
							<div class="email mb-2">
								<!-- <label class="sr-only" for="emailMitra">Your Name</label> -->
								<input id="lokasiMitra" name="lokasiMitra" type="text" class="form-control lokasiMitra" placeholder="Lokasi" required="required">
							</div>
							<div class="email mb-2">
								<!-- <label class="sr-only" for="emailMitra">Your Name</label> -->
								<input id="stokPertalite" name="stokPertalite" type="text" class="form-control stokPertalite" placeholder="Stok Pertalite" required="required">
							</div>
							<div class="email mb-2">
								<!-- <label class="sr-only" for="emailMitra">Your Name</label> -->
								<input id="stokPertamax" name="stokPertamax" type="text" class="form-control stokPertamax" placeholder="Stok Pertamax" required="required">
							</div>

							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto" name="daftar_mitra">Sign Up</button>
							</div>
						</form>
						<!--//auth-form-->

						<div class="auth-option text-center pt-2">Already have an account? <a class="text-link" href="login_mitra.php">Login</a></div>
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