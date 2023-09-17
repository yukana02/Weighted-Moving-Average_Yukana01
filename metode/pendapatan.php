<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Pendapatan</title>
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

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
        <a class="nav-link collapsed" href="dashboard.php">
          <i class="bi bi-grid"></i><span>Dashboard</span>
        </a>
        <li class="nav-item">
        <a class="nav-link " href="pendapatan.php">
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
      <h1>Pendapatan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">harian</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">
              <!-- <div class="card  info-card"> -->
                
                  
                <div class="card-body card mt-4">
                  <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#basicModal">
                        Buat Arsip Baru
                    </button>
                    <div class="modal fade" id="basicModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Warning</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#" method="POST">
                                        <div class="row" style="text-align:center">
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="show_NAMA" class="form-label mt-3 mb-3">BUAT ARSIP BARU</label>
                                                    <input type="text" name="BUAT_NAMA" class="form-control" placeholder="MASUKKAN NAMA">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="show_tagihan" class="form-label">MULAI TANGGAL</label>
                                                    <input type="text" name="form_tgl" id="date" class="form-control" placeholder="YYYY-MM-DD">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="show_tagihan" class="form-label">PENDAPATAN</label>
                                                    <input type="number" name="form_pendapatan" class="form-control" placeholder="Rp">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit2" name="submit2" class="btn btn-primary">SUBMIT</button>
                                    </form>
                                    <?php
                                    include('../connection.php');
                                    error_reporting(0);
                                    if (isset($_POST['submit2'])) {
                                        $buat_nama = $_POST['BUAT_NAMA'];
                                        $form_tgl = $_POST['form_tgl'];
                                        $form_pendapatan = $_POST['form_pendapatan'];
                                        $query = mysqli_query($conn, "SELECT TGL_HAR FROM HARIAN WHERE TGL_HAR = '$form_tgl'");
                                          if($query->num_rows > 0) {
                                            echo "<script>alert('Tanggal Sudah Terdaftar');</script>";
                                          }else{
                                            $result1 = mysqli_query($conn, "INSERT INTO `HARIAN` (`NAMA_HAR`,`TGL_HAR`,`PEN_HAR`) VALUES ('$buat_nama','$form_tgl','$form_pendapatan')");
                                          }
                                        if ($result1) {
                                            echo "<div class='mt-4'><div class='alert alert-success' role='alert'>Data berhasil disimpan</div></div>";
                                            $select = mysqli_query($conn, "SELECT * FROM HARIAN WHERE NAMA_HAR = '$buat_nama'");
                                            $row = mysqli_fetch_array($select);
                                            $HAS = "HAS";
                                            $tambah_hasil = mysqli_query($conn, "INSERT INTO `HASIL` (`ID_FORCAST`,`ID_HAR`) VALUES ('$HAS$row[ID_HAR]','$row[ID_HAR]')");

                                            if ($tambah_hasil) {
                                                $tambah_penanda = mysqli_query($conn, "UPDATE HARIAN SET FORCAST_HAR = '$row[ID_HAR]' WHERE NAMA_HAR = '$buat_nama'");
                                            }
                                        } else {
                                            echo "<div class='mt-4'><div class='alert alert-danger' role='alert'>Gagal menyimpan data</div></div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                                            
                  <h4 class = "mt-3 mb-3">Daftar Arsip Pendapatan</h4>
                    <table class="table table-borderless datatable">
                    
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama</th>
                              <th>Tgl Mulai</th>
                              <th>Edit & Hapus</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                        session_start();
                        include('../connection.php');
                        $no = 1; 
                        $result = mysqli_query($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR ASC");

                        while($row = mysqli_fetch_array($result)) {
                            $id_har = $row['ID_HAR'];
                            $forcast_har = $row['FORCAST_HAR']; // Mendapatkan nilai FORCAST_HAR dari tabel HARIAN
                            
                    ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $row['NAMA_HAR'] ?></td>
                                <td><?php echo $row['TGL_HAR'] ?></td>
                                <td class="text-center">
                                    <a href="edit_pendapatan.php?FORCAST_HAR=<?php echo $forcast_har; ?>" class="btn btn-sm btn-primary">Edit & Hapus</a>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>

                      </tbody>
                    </table>
                <!-- </div> -->
                    </div>
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

  <!-- Template Main JS File -->
  

</body>
</html>