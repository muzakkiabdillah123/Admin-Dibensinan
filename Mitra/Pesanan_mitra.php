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

$idMitra = $mitra->getDocumentId("emailMitra", $_SESSION['emailMitra']);

$namaMitra = $mitra->setDocumentName($idMitra)->getData("namaMitra");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dibensinan</title>
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
        <a class="navbar-brand me-auto text-danger" href="#">Pesa<span class="text-warning">nan</span></a>
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
        </div>
      </div>
      <div class="slider-body px-1">
        <nav class="nav flex-column">
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="index_mitra.php">
            <i class="fa fa-home fa-lg box-icon" aria-hidden="true"></i>Home
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="profile_mitra.php">
            <i class="fa fa-user fa-lg box-icon" aria-hidden="true"></i>Profil
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link active px-3" href="pesanan_mitra.php">
            <i class="fa fa-inbox fa-lg box-icon" aria-hidden="true"></i>Pesanan
          </a>
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
        <div class="row g-3 mb-3">
          <?php
          $data = $pesanan->getDocumentFromKey("namaMitra", $namaMitra);
          // $data = $pesanan->getAllDocument();
          $i = 0;
          foreach ($data as $key => $value) :
          ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
              <div class="card p-2 shadow">
                <div class="item border-bottom py-3">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-2">
                        <h4> <i class="fa fa-inbox fa-2x box-icon" aria-hidden="true"> </i> <b> <?php
                                                                                                print($value["namaUser"]);
                                                                                                ?></b></h4>
                      </div>
                    </div>
                  </div>
                  <!--//row-->
                </div>
                <!--//tanggal pesan-->
                <div class="item border-bottom border-top py-2">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-2"><strong>Tanggal pesanan</strong></div>
                    </div>
                    <!--//col-->
                    <div class="col text-end">
                      <p class="item-label mb-0">
                        <?php
                        print($value["tglPesan"]);
                        ?>
                      </p>
                    </div>
                    <!--//col-->
                  </div>
                  <!--//row-->
                </div>
                <!--//lokasi-->
                <div class="item border-bottom py-2">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-2"><strong>Lokasi</strong></div>
                    </div>
                    <!--//col-->
                    <div class="col text-end">
                      <p class="item-label mb-0">
                        <?php
                        print($value["lokasi"]);
                        ?>
                      </p>
                    </div>
                    <!--//col-->
                  </div>
                  <!--//row-->
                </div>
                <!--//no wa-->
                <div class="item border-bottom py-2">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-0"><strong>Nomor Whatsapp</strong></div>
                    </div>
                    <!--//col-->
                    <div class="col text-end">
                      <p class="item-label mb-0">
                        <?php
                        print($value["noWA"]);
                        ?>
                      </p>
                    </div>
                    <!--//col-->
                  </div>
                  <!--//row-->
                </div>
                <!--//jenis bensin-->
                <div class="item border-bottom py-2">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-2"><strong>Jenis Bensin</strong></div>
                    </div>
                    <!--//col-->
                    <div class="col text-end">
                      <p class="item-label mb-0">
                        <?php
                        print($value["jenisBensin"]);
                        ?>
                      </p>
                    </div>
                    <!--//col-->
                  </div>
                  <!--//row-->
                </div>
                <!--//total liter-->
                <div class="item border-bottom py-2">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-2"><strong>Jumlah dalam Liter</strong></div>
                    </div>
                    <!--//col-->
                    <div class="col text-end">
                      <p class="item-label mb-0">
                        <?php
                        print($value["totalLiter"]);
                        ?>
                      </p>
                    </div>
                    <!--//col-->
                  </div>
                  <!--//row-->
                </div>
                <!--//total bayar-->
                <div class="item border-bottom py-2">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <div class="item-label mb-2"><strong>Total bayar</strong></div>
                    </div>
                    <!--//col-->
                    <div class="col text-end">
                      <p class="item-label mb-0">
                        <?php
                        print($value["totalBayar"]);
                        ?>
                      </p>
                    </div>
                    <!--//col-->
                  </div>
                  <!--//row-->
                </div>
                <!--//item-->
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
  <script src="../dist/js/jquery.js"></script>
  <script src="../assets/app/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <script src="../dist/js/index.js"></script>

</body>

</html>