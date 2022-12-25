<?php
session_start();
if (!isset($_SESSION["login_mitra"])) {
    header("Location: login_mitra.php");
    exit;
}

require_once "../vendor/autoload.php";

use App\Models\Firestore;

$db = new Firestore();
$db2 = new Firestore();
$mitra = $db->setCollectionName("mitra");
$pesanan = $db2->setCollectionName("transaksiGelap");

// print field nama mitra in pesanan

$idMitra = $mitra->getDocumentId("emailMitra", $_SESSION['emailMitra']);

// get nama mitra
$namaMitra = $mitra->setDocumentName($idMitra)->getData("namaMitra");

$countPesananMitra = $pesanan->countDocumentFromKey("namaMitra", $namaMitra);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dibensinan|Dashboard Mitra</title>
    <link rel="stylesheet" href="../assets/app/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../dist/css/index_mitra.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <nav class="navbar navbar-expand-md py-1">
            <div class="container-fluid">
                <button class="btn btn-default" id="btn-slider" type="button">
                    <i class="fa fa-bars fa-lg" aria-hidden="true"></i>
                </button>
                <a class="navbar-brand me-auto text-danger" href="#">Dash<span class="text-warning">Board</span></a>
                <ul class="nav ms-auto">
                    <li class="nav-item dropstart">
                        <a class="nav-link text-dark ps-3 pe-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="../images/user/mitra.jpg" alt="user" class="img-user">
                        </a>
                        <div class="dropdown-menu mt-2 pt-0" aria-labelledby="navbarDropdown">
                            <div class="d-flex p-3 border-bottom mb-2">
                                <img src="../images/user/mitra.jpg" alt="user" class="img-user me-2">
                                <div class="d-block">
                                    <p class="fw-bold m-0 lh-1">
                                        <?php
                                        print($mitra->setDocumentName($idMitra)->getData("namaMitra"));
                                        ?>
                                    </p>
                                    <small>
                                        <?php
                                        print($mitra->setDocumentName($idMitra)->getData("emailMitra"));
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <a class="dropdown-item" href="profile_mitra.php">
                                <i class="fa fa-user fa-lg me-3" aria-hidden="true"></i>Profil
                            </a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="logout_mitra.php">
                                <i class="fa fa-sign-out fa-lg me-2" aria-hidden="true"></i>Keluar
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="slider" id="sliders">
            <div class="slider-head">
                <div class="d-block pt-4 pb-3 px-3">
                    <img src="../images/LogoBulat.png" alt="user" class="slider-img-user mb-0">
                    <p class="fw-bold mb-0 lh-1 text-white">MITRA DIBENSINAN</p>
                    <!-- <small class="text-white">YourAccount@gmail.com</small> -->
                </div>
            </div>
            <div class="slider-body px-1">
                <nav class="nav flex-column">
                    <hr class="soft my-1 bg-white">
                    <a class="nav-link active px-3" href="index_mitra.php">
                        <i class="fa fa-home fa-lg box-icon" aria-hidden="true"></i>Home
                    </a>
                    <hr class="soft my-1 bg-white">
                    <a class="nav-link px-3" href="profile_mitra.php">
                        <i class="fa fa-user fa-lg box-icon" aria-hidden="true"></i>Profil
                    </a>
                    <hr class="soft my-1 bg-white">
                    <a class="nav-link px-3" href="pesanan_mitra.php">
                        <i class="fa fa-inbox fa-lg box-icon" aria-hidden="true"></i>Pesanan
                    </a>
                    <!-- <a class="nav-link px-3" href="#">
                        <i class="fa fa-envelope fa-lg box-icon" aria-hidden="true"></i>Message
                    </a> -->
                    <hr class="soft my-1 bg-white">
                    <a class="nav-link px-3" href="produk_mitra.php">
                        <i class="fa fa-id-card fa-lg box-icon" aria-hidden="true"></i>Produk
                    </a>
                    <hr class="soft my-1 bg-white">
                    <a class="nav-link px-3" href="logout_mitra.php">
                        <i class="fa fa-sign-out fa-lg box-icon" aria-hidden="true"></i>Keluar
                    </a>
                </nav>
            </div>
        </div>

        <div class="main-pages">
            <div class="container-fluid">
                <div class="row g-2 mb-3">
                    <div class="col-12">
                        <div class="d-block-contain rounded shadow p-3">
                            <h2>DIBENSINAN</h2>
                            <p>Dibensinan merupakan aplikasi penyedia jasa pengantaran bahan bakar minyak untuk para pengendara roda 2 dan 4 yang berada di wilayah Bandung dan sekitarnya
                            </p>
                            <p><b>#janganDiDorongDIBENSINANaja</b></p>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="card p-2 shadow border-warning">
                            <div class="border-warning">
                                <div class=" align-items-center px-2" style="height: 22.5rem;">
                                    <br><br>
                                    <h1 class="text-center mt-5 pt-4 namaMitra">
                                        <?php
                                        print($mitra->setDocumentName($idMitra)->getData("namaMitra"));
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="card mb-0 p-2 shadow border-warning">
                            <div class="border-warning">
                                <div class=" align-items-center px-2" style="height: 16rem;">
                                    <br>
                                    <p class=" pesanan text-center  pt-5">
                                        <?php
                                        print($countPesananMitra);
                                        ?>
                                    </p>
                                </div>
                                <center>
                                    <div class="text-decoration-none">
                                        <a class="text-decoration-none" href="pesanan_mitra.php">
                                            <div class="card-footer mb-2">
                                                <!-- <i  class="fa fa-inbox fa-lg box-icon" aria-hidden="true"></i> -->
                                                <h2 class="text-center mt-3"> <i class="fa fa-inbox fa-lg box-icon" aria-hidden="true"></i> Jumlah Pesanan</h2>
                                                <!-- <small class="text-center fw-bold">Jumlah Pesanan</small> -->
                                            </div>
                                        </a>
                                    </div>
                                </center>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="slider-background" id="sliders-background"></div>
    <script src="../dist/js/jquery.js"></script>
    <script src="../assets/app/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="../dist/js/index.js"></script>

</body>

</html>