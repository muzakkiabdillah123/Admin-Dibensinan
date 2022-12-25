<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require_once "vendor/autoload.php";

use App\Models\Firestore;

$db = new Firestore();
$db2 = new Firestore();
$pengguna = $db->setCollectionName("penggunaHokya");
$mitra = $db2->setCollectionName("mitra");

$idAdmin = $pengguna->getDocumentId("email", $_SESSION['email']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dibensinan | Mitra</title>
  <link rel="stylesheet" href="assets/app/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/icons/css/font-awesome.min.css">
  <link rel="stylesheet" href="dist/css/index.css">
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
              <img src="images/user/admin.jpg" alt="user" class="img-user">
            </a>
            <div class="dropdown-menu mt-2 pt-0" aria-labelledby="navbarDropdown">
              <div class="d-flex p-3 border-bottom mb-2">
                <img src="images/user/admin.jpg" alt="user" class="img-user me-2">
                <div class="d-block">
                  <p class="fw-bold m-0 lh-1">
                    <?php
                    print($pengguna->setDocumentName($idAdmin)->getData("nama"));
                    ?>
                  </p>
                  <small>
                    <?php
                    print($pengguna->setDocumentName($idAdmin)->getData("email"));
                    ?>
                  </small>
                </div>
              </div>
              <a class="dropdown-item" href="profile.php">
                <i class="fa fa-user fa-lg me-3" aria-hidden="true"></i>Profil
              </a>
              <hr class="dropdown-divider">
              <a class="dropdown-item" href="logout.php">
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
          <img src="images/LogoBulat.png" alt="user" class="slider-img-user mb-0">
          <p class="fw-bold mb-0 lh-1 text-white">DIBENSINAN</p>
          <!-- <small class="text-white">YourAccount@gmail.com</small> -->
        </div>
      </div>
      <div class="slider-body px-1">
        <nav class="nav flex-column">
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="index.php">
            <i class="fa fa-home fa-lg box-icon" aria-hidden="true"></i>Home
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="profile.php">
            <i class="fa fa-user fa-lg box-icon" aria-hidden="true"></i>Profil
          </a>
          <hr class="soft my-1 bg-white">
          <!-- <a class="nav-link px-3" href="#">
                        <i class="fa fa-dropbox fa-lg box-icon" aria-hidden="true"></i>Produk
                    </a> -->
          <a class="nav-link px-3" href="pengguna.php">
            <i class="fa fa-users fa-lg box-icon" aria-hidden="true"></i>Pengguna
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="pesanan.php">
            <i class="fa fa-inbox fa-lg box-icon" aria-hidden="true"></i>Pesanan
          </a>
          <!-- <a class="nav-link px-3" href="#">
                        <i class="fa fa-envelope fa-lg box-icon" aria-hidden="true"></i>Message
                    </a> -->
          <hr class="soft my-1 bg-white">
          <a class="nav-link active px-3" href="mitra.php">
            <i class="fa fa-id-card fa-lg box-icon" aria-hidden="true"></i>Mitra
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="logout.php">
            <i class="fa fa-sign-out fa-lg box-icon" aria-hidden="true"></i>Keluar
          </a>
        </nav>
      </div>
    </div>

    <div class="main-pages">
      <div class="container-fluid">
        <div class="row g-3 mb-3">
          <?php
          $data = $mitra->getAllDocument();
          $i = 0;
          foreach ($data as $key => $value) :
          ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
              <div class="card p-2 shadow">

                <form action="" method="post">
                  <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-auto">
                        <div class="item-label mb-2">
                          <h4> <i class="fa fa-id-card fa-2x box-icon" aria-hidden="true"> </i> <b>
                              <?php
                              print($value['namaMitra']);
                              ?>
                            </b></h4>
                        </div>
                      </div>
                      <!--//col-->
                      <div class="col text-end">
                        <button class="btn btn-selengkapnya mb-0">
                          <a href="hapusMitra.php?namaMitra=<?= $value["namaMitra"]; ?>" onclick="return confirm('Hapus permanen data ini?');">
                            Hapus</a>
                        </button>
                      </div>
                    </div>
                    <!--//row-->
                  </div>
                  <!--//item-->
                  <div class="item border-bottom border-top py-2">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-auto">
                        <div class="item-label mb-0"><strong>Email</strong></div>
                      </div>
                      <!--//col-->
                      <div class="col text-end">
                        <p class="item-label mb-0">
                          <?php
                          print($value['emailMitra']);
                          ?>
                        </p>
                      </div>
                      <!--//col-->
                    </div>
                    <!--//row-->
                  </div>
                  <!--//item-->
                  <div class="item border-bottom border-top py-2">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-auto">
                        <div class="item-label mb-0"><strong>Lokasi</strong></div>
                      </div>
                      <!--//col-->
                      <div class="col text-end">
                        <p class="item-label mb-0">
                          <?php
                          print($value['lokasiMitra']);
                          ?>
                        </p>
                      </div>
                      <!--//col-->
                    </div>
                    <!--//row-->
                  </div>
                  <!--//item-->
                  <div class="item border-bottom py-2">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-auto">
                        <div class="item-label mb-2"><strong>Stok Pertalite</strong></div>
                      </div>
                      <!--//col-->
                      <div class="col text-end">
                        <p class="item-label mb-0">
                          <?php
                          print($value['stokPertalite']);
                          ?>
                        </p>
                      </div>
                      <!--//col-->
                    </div>
                    <!--//row-->
                  </div>
                  <!--//item-->
                  <div class="item border-bottom py-2">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-auto">
                        <div class="item-label mb-2"><strong>Stok Pertamax</strong></div>
                      </div>
                      <!--//col-->
                      <div class="col text-end">
                        <p class="item-label mb-0">
                          <?php
                          print($value['stokPertamax']);
                          ?>
                        </p>
                      </div>
                      <!--//col-->
                    </div>
                    <!--//row-->
                  </div>
                  <!--//item-->
                  <div class="item border-bottom py-2">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-auto">
                        <div class="item-label mb-2"><strong>Nomor WA</strong></div>
                      </div>
                      <!--//col-->
                      <div class="col text-end">
                        <p class="item-label mb-0">
                          <?php
                          print($value['waMitra']);
                          ?>
                        </p>
                      </div>
                      <!--//col-->
                    </div>
                    <!--//row-->
                  </div>
                  <br>
              </div>
            </div>
          <?php
            $i++;
          endforeach;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="slider-background" id="sliders-background"></div>
  <script src="dist/js/jquery.js"></script>
  <script src="assets/app/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <script src="dist/js/index.js"></script>

</body>

</html>