<?php session_start(); 
  $_SESSION['forcast_har'] = $_GET['FORCAST_HAR'];
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

  <title>Dashboard - Harian</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="" alt="">
        <span class="d-none d-lg-block" class="justify">WMA</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
      
      <span class="d-none d-lg-block">Weighted Moving Average</span>
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

    <div class="pagetitle">
      <h1>Prediksi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Edit data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
      <!-- Button trigger modal -->

       <!-- Basic Modal -->
       <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
          Hapus Projek
        </button>
        <div class="modal fade" id="basicModal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Hapus Projek Prediksi 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <?php
                $forcast_har = $_SESSION['forcast_har'];
                ?>
                <a href="delete_projek.php?FORCAST_HAR=<?php echo $forcast_har; ?>" class="btn btn-danger">Hapus</a>
              </div>
            </div>
          </div>
        </div><!-- End Basic Modal-->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">
              <!-- <div class="card  info-card"> -->
              <div class="card-body card mt-4">
                <form action="edit_pendapatan.php?FORCAST_HAR=<?=$_SESSION['forcast_har']?>" method="POST">
                 <?php
                 include ('../connection.php');
                 $forcast_har = $_SESSION['forcast_har'];
                 $query = "SELECT * FROM HARIAN WHERE FORCAST_HAR = '$forcast_har' ORDER BY TGL_HAR DESC LIMIT 1";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $tgl_terakhir = $row['TGL_HAR'];
                        // Gunakan nilai $tgl_terakhir sesuai kebutuhan Anda
                    } else {
                        // Data tidak ditemukan
                    }

                 ?>
                  <div class="row mt-3" style="text-align:center">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="show_tagihan" class="form-label">TANGGAL TERAKHIR</label>
                            <input type="text" name="form_tgl" id="date" class="form-control" value="<?php echo $tgl_terakhir; ?>">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="show_tagihan" class="form-label">PENDAPATAN</label>
                            <input type="number" name="form_pendapatan" class="form-control" placeholder="Rp">
                          </div>
                        </div>
                        <div class="button mt-3">
                          
                          <button type="submit" name="submit" class="btn btn-primary">SUBMIT</button>
                           <?php
                           error_reporting(0);
                           include('../connection.php');
                           if(isset($_POST['submit'])){
                            $forecast_har = $_SESSION['forcast_har'];
                            $form_tgl = $_POST['form_tgl'];
                            $form_pendapatan = $_POST['form_pendapatan'];
                            $query = mysqli_query($conn, "SELECT TGL_HAR FROM HARIAN WHERE TGL_HAR = '$form_tgl'");
                            if($query->num_rows > 0) {
                              echo "<script>alert('Tanggal Sudah Terdaftar, Edit Atau Input Tanggal Baru ');</script>";
                            }else{
                            $result1 = mysqli_query($conn, "INSERT INTO `HARIAN` (`FORCAST_HAR`,`TGL_HAR`,`PEN_HAR`) VALUES ('$forecast_har','$form_tgl','$form_pendapatan')");
                            echo "<div class='mt-2 ml-1 mr-4 '><div class='alert alert-success' role='alert'>DATA " . $form_tgl . ", " . $form_pendapatan . " Berhasil ditambahkan.</div></div>";
                            }
                            if($result1){
                              $result = mysqli_query($conn, "SELECT * FROM HARIAN WHERE FORCAST_HAR = '$forecast_har'");
                              if (mysqli_num_rows($result) > 0) {
                                  $data = array();
                                  $bobot = array(0.2, 0.3, 0.5);
                              
                                  while ($row = mysqli_fetch_array($result)) {
                                  $data[] = $row['PEN_HAR'];
                                  }
                                  $count_data = count($data);
                                  $total = array_sum($data);
                                  $prediksi = 0;
                                  for ($i = $count_data - 3; $i <= $count_data - 1; $i++) {
                                      if (isset($data[$i]) && isset($bobot[$i - ($count_data - 3)])) {
                                          $prediksi += $data[$i] * $bobot[$i - ($count_data - 3)];
                                      }
                                  }
                                  $prediksi = $prediksi / array_sum($bobot);
                                  // echo $prediksi;
                                  if($prediksi){
                                    $select = mysqli_query($conn, "SELECT * FROM HARIAN WHERE FORCAST_HAR = '$forcast_har' ORDER BY TGL_HAR ASC LIMIT 1");
                                    $getselect = mysqli_fetch_array($select);
                                    $tanda = $getselect['ID_HAR'];
                                    // echo $tanda;
                                    if($select){
                                    $update_hasil = mysqli_query ($conn, "UPDATE HASIL SET HASIL_PREDIK = '$prediksi' WHERE ID_HAR = '$tanda'");
                                      if($update_hasil){
                                        $update_total = mysqli_query($conn, "UPDATE HARIAN SET TOTAL = '$total' WHERE ID_HAR = '$tanda'");
                                      
                                      }
                                    }
                                  }    
                                }
                              }
                            }
                           
                           ?> 
                        </div>
                  </div>
                </form>
                </div>

                <div class="card-body card mt-4">
                    <table class="table table-borderless datatable">
                      <thead>
                          <tr>
                              <th scope="col">NO</th>
                              <th scope="col">TANGGAL</th>
                              <th scope="col">PENDAPATAN</th>
                              <th scope="col">EDIT NOMINAL</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php

                          include('../connection.php');

                          if (isset($_GET['FORCAST_HAR']) || isset($_SESSION['forcast_har'])) {
                              $forecast_har = $_GET['FORCAST_HAR'];
                              $forecast_har = $_SESSION['forcast_har'];
                              $queryGetData = "SELECT * FROM HARIAN WHERE FORCAST_HAR='$forecast_har'";
                              $result = mysqli_query($conn, $queryGetData);

                              // ...
                              $no = 1;
                              while ($row = mysqli_fetch_array($result)) {
                                  ?>
                                  <tr>
                                      <td><?php echo $no++ ?></td>
                                      <td><?php echo $row['TGL_HAR'] ?></td>
                                      <td><?php echo $row['PEN_HAR'] ?></td>
                                      <td class="text-center">
                                      <a href="edit_nominal.php?TGL_HAR=<?php echo $row['TGL_HAR']; ?>" class="btn btn-sm btn-primary">Edit Nominal</a>
                                      </td>
                                  </tr>
                                  <?php
                              }
                          }
                          ?>
                      </tbody>
                    </table>
                </div>
              <!-- </div>   -->
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
  <!-- <script src="../assets/js/jquery.js"></script> -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="../assets/js/main.js"></script>
  


  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script>
  $( function() {
    $( "#date" ).datepicker({
      dateFormat: "yy-mm-dd"
    });
  } );
  
  </script>

</body>
</html>