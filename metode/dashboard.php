<?php 
include('../connection.php');
session_start(); 
if($user = $_SESSION['userr']){
  $result = mysqli_query($conn , "select * from admin WHERE username = '$user'");
  $row = mysqli_fetch_array($result);
}
 else{
  echo header('Location:../index.php');
}
// error_reporting('0');?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="images/nobg-alexanet.png" type="image/icon type">
  <title>Dashboard - Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="" alt="">
        <span class="d-none d-lg-block" class="justify">WMA</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <span class="d-none d-lg-block">&nbsp &nbsp &nbsp &nbsp Weighted Moving Average</span>
    </div><!-- End Logo -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i><span>Dashboard</span>
        </a>
        <li class="nav-item">
        <a class="nav-link collapsed" href="pendapatan.php">
          <i class="bi bi-journal-text"></i><span>Pendapatan</span>
        </a>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="hasil.php">
          <i class="bi bi-gem"></i><span>Prediksi</span>
        </a>
      </li><!-- End Icons Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Logout Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">
              <!-- <div class="card info-card customers-card"> -->
                
                <style>
                            .data-container {
                                display: flex;
                                justify-content: space-between;
                            }
                            .data-item {
                                flex: 1;
                                text-align: center;
                            }
                        </style>

                        <?php
                        include('../connection.php');
                        $result = mysqli_query($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR DESC LIMIT 3");
                        echo '<div class="data-container">';
                        while($data = mysqli_fetch_array($result)) {
                            $bulan = $data['NAMA_HAR'];
                            $pendatapan = $data['TOTAL'];
                            echo '<div class="data-item card-body card">';
                            echo '<br><br>';
                            echo '<h4>'.$bulan.'</h4>';
                            echo '<h5>' .number_format($pendatapan).'</h5>';
                            echo '</div>';
                        }
                        echo '</div>';
                        ?>

                    
                <div class="card-body card ">
                    <br><br>
                    <center><h5>Weighted Moving Average</h5></center><h5>
                        <br>
                    <div class="isi" style="text-align: justify;">
                        Weighted Moving Average atau biasa di singkan WMA merupakan Metode memprediksi dengan cara memberikan bobot pada data n periode sebelumnya, 
                        kemudian membaginya dengan jumlah bobot. Bobot terbesar diberikan ke data 1 (satu) periode sebelumnya (Aji dkk.,2022). 
                        Pendapat lain mengatakan Metode weighted moving average (WMA) atau metode rata-rata bergerak tertimbang yang terlebih dahulu menejemen data menetapkan bobot (weighted factor) 
                        dari data yang ada. Penetapan bobot dimaksud besifat subjektif, tergantung pada pengalaman dan ketentuan analis data. 
                        Perhitungan metode weighted moving average setiap historis mempunyai bobot yang berbeda, bobot terbesar diberikan pada data historis yang paling akhir
                        dalam setiap periode dibandingkan dengan data historis yang sebelumnya sebab data yang paling baru merupakan data yang paling relevan dalam forecasting (Solikin dan Hardini, 2019)
                    </div>
                </div>
              <!-- </div> -->
            </div><!-- End Customers Card -->    
          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>YUDA J.P.</span></strong>. Weighted Moving Average
    </div>
    <div class="credits">
      Designed by Yuda J.P.</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>