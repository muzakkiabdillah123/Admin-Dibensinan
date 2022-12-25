<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require_once "vendor/autoload.php";

use App\Models\Firestore;

$db = new Firestore();
$pengguna = $db->setCollectionName("penggunaHokya");

$idAdmin = $pengguna->getDocumentId("email", $_SESSION['email']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dibensinan | Profil Admin</title>
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
          <a class="nav-link active px-3" href="profile.php">
            <i class="fa fa-user fa-lg box-icon" aria-hidden="true"></i>Profil
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="Pengguna.php">
            <i class="fa fa-users fa-lg box-icon" aria-hidden="true"></i>Pengguna
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="pesanan.php">
            <i class="fa fa-inbox fa-lg box-icon" aria-hidden="true"></i>Pesanan
          </a>
          <hr class="soft my-1 bg-white">
          <a class="nav-link px-3" href="mitra.php">
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
          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card p-2 shadow">
              <div class="d-flex align-items-center px-2">
                <i class="fa fa-user float-start fa-3x py-auto" aria-hidden="true"></i>
                <div class="card-body text-start">
                  <b>
                    <h4>Profil Saya</h4>
                  </b>
                </div>
              </div>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <!-- <a href="#aa"><h6 class="mb-0 text-sm">Jaringan Komputer</h6></a> -->
                            <p class="text-xs text-dark fw-bold mb-0">Nama</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- <p class="text-xs font-weight-bold mb-0">3/Gasal</p> -->
                        <p class="text-xs text-dark mb-0">
                          <?php
                          print($pengguna->setDocumentName($idAdmin)->getData("nama"));
                          ?>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <!-- <a href="#aa"><h6 class="mb-0 text-sm">Sistem Operasi</h6></a> -->
                            <p class="text-xs text-drk fw-bold mb-0">Email</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- <p class="text-xs font-weight-bold mb-0">3/Gasal</p> -->
                        <p class="text-xs text-dark mb-0">
                          <?php
                          print($pengguna->setDocumentName($idAdmin)->getData("email"));
                          ?>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <!-- <a href="#aa"><h6 class="mb-0 text-sm">Pemrograman Internet</h6></a> -->
                            <p class="text-xs text-dark fw-bold mb-0">Nomor Handphone</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs text-dark pr-20px mb-0">
                          <?php
                          print($pengguna->setDocumentName($idAdmin)->getData("noHp"));
                          ?>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <!-- <a href="#aa"><h6 class="mb-0 text-sm">Pemrograman Internet</h6></a> -->
                            <p class="text-xs text-dark fw-bold mb-0">Alamat</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs text-dark pr-20px mb-0">
                          <?php
                          print($pengguna->setDocumentName($idAdmin)->getData("alamat"));
                          ?>
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br><br><br><br><br><br>
                <br><br>
                <center>
                  <a href="Edit_profil.php">
                    <button type="submit" class="btn btn-editprofil mb-1">Edit Profil</button>
                  </a>
                </center>
              </div>
            </div>
          </div>
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