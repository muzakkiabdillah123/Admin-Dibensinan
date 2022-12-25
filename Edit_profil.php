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

// Apakah submit sudah di klik
if (isset($_POST["simpan"])) {
    // Mengambil data email dan password dari _POST
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $noHp = $_POST["noHp"];
    $alamat = $_POST["alamat"];

    $pengguna->setDocumentName($idAdmin)->updateDocument("nama", $nama);
    $pengguna->setDocumentName($idAdmin)->updateDocument("email", $email);
    $pengguna->setDocumentName($idAdmin)->updateDocument("noHp", $noHp);
    $pengguna->setDocumentName($idAdmin)->updateDocument("alamat", $alamat);

    // alert
    echo "<script>
            alert('Data berhasil diubah');
            document.location.href = 'Profile.php';
        </script>";
}

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
                    <!-- <a class="nav-link px-3" href="#">
                        <i class="fa fa-dropbox fa-lg box-icon" aria-hidden="true"></i>Produk
                    </a> -->
                    <a class="nav-link px-3" href="Pengguna.php">
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
                                <i class="fa fa-edit float-start fa-3x py-auto" aria-hidden="true"></i>
                                <div class="card-body text-start">
                                    <b>
                                        <h4>Edit Profil</h4>
                                    </b>
                                </div>
                            </div>
                            <form action="" method="post">
                                <div class="form-group mb-3 fw-bold">
                                    <label for="nama">Nama:</label>
                                    <input type="text" class="form-control" id="nama" value="<?php
                                                                                                print($pengguna->setDocumentName($idAdmin)->getData("nama"));
                                                                                                ?>" name="nama" required>
                                </div>
                                <div class="form-group mb-3 fw-bold">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" value="<?php
                                                                                                print($pengguna->setDocumentName($idAdmin)->getData("email"));
                                                                                                ?>" name="email" required>
                                </div>
                                <div class="form-group mb-3 fw-bold">
                                    <label for="noHp">Nomor Handphone:</label>
                                    <input type="text" class="form-control" id="noHp" value="<?php
                                                                                                print($pengguna->setDocumentName($idAdmin)->getData("noHp"));
                                                                                                ?>" name="noHp" required>
                                </div>
                                <div class="form-group mb-5 fw-bold">
                                    <label for="katasandi">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" value="<?php
                                                                                                print($pengguna->setDocumentName($idAdmin)->getData("alamat"));
                                                                                                ?>" name="alamat" required>
                                </div>
                                <br><br><br><br><br>
                                <center>
                                    <a href="Profile.php">
                                        <button type="submit" class="btn btn-simpan mt-3 fw-bold" name="simpan"> Simpan</button>
                                    </a>
                                </center>
                            </form>
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



<!-- <div class="form-group mb-3 fw-bold">
                              <label for="upload">Upload Foto:</label>
                              <div class="input-group-append">
                                <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                                <label for="upload" class="btn btn-light m-0 px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                              </div>
                            </div> -->
<!--                             
                            <div class="input-group mb-3 px-2 py-2 bg-white shadow-sm">
                              <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                              <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                              <div class="input-group-append">
                                  <label for="upload" class="btn btn-light m-0 px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                              </div>
                            </div> -->