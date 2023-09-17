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

  <title>Dashboard - Prediksi</title>
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
        <a class="nav-link collapsed" href="pendapatan.php">
          <i class="bi bi-journal-text"></i><span>Pendapatan</span>
        </a>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link " href="hasil.php">
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
      <h1>Hasil</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item active">Hasil Semua Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="jf" style="text-align: right; margin-right: 20px;">
    <a href='cetak_bul.php' class='btn btn-sm btn-primary'>cetak</a>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <!-- <div class="card  info-card"> -->
                            <div class="card-body card mt-4">
                               
                       <table class="table table-borderless datatable">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama</th>
                              <th>Pendapatan</th>
                              <th>WMA</th>
                              <th>Mape</th>
                              <th>Mse</th>
                              <th>Mad</th>
                              <th>Prediksi Harian</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          error_reporting(0);
                          include('../connection.php');
                          $result = mysqli_query($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR ASC ");
                          
                          if (mysqli_num_rows($result) > 0) {
                              $data = array();
                              $bobot = array(0.2, 0.3, 0.5);
                            $tgl = array();

                                $result = mysqli_query($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR DESC LIMIT 122");

                                $dataTerbaru = array(); // Membuat array kosong untuk menyimpan data terbaru

                                while ($row = mysqli_fetch_array($result)) {
                                    $dataTerbaru[] = $row;
                                }

                                $dataTerbalik = array_reverse($dataTerbaru); // Membalikkan urutan array

                                foreach ($dataTerbalik as $row) {
                                    $tgl[] = date('M-Y', strtotime($row['TGL_HAR']));
                                    $forcast_har[] = $row['FORCAST_HAR'];
                                    $nama[] = $row['NAMA_HAR'];
                                    $data[] = $row['TOTAL'];
                                }

                                $addTgl = date('M-Y', strtotime('+1 month', strtotime(end($tgl))));
                                array_push($tgl, $addTgl);

                              
                              
                              $count_data = count($data);

                                  $wma = array();
                                  for ($i = 0; $i <= $count_data - 3; $i++) {
                                      $sum = 0;
                                      for ($j = 0; $j < 3; $j++) {
                                          $sum += $data[$i + $j] * $bobot[$j];
                                      }
                                      if ($i == $count_data - 3) {
                                          $wma[] = $sum / array_sum($bobot); 
                                      } else {
                                          $wma[] = $sum;
                                      }
                                  }
                                 
                                  // Prediksi Data Terbaru
                                  $prediksi = 0;
                                  for ($i = $count_data - 3; $i <= $count_data - 1; $i++) {
                                      if (isset($data[$i]) && isset($bobot[$i - ($count_data - 3)])) {
                                          $prediksi += $data[$i] * $bobot[$i - ($count_data - 3)];
                                      }
                                  }
                                  $prediksi = $prediksi / array_sum($bobot);
                                  // MAPE
                                
                                for ($i = 3; $i <= $count_data - 1; $i++) {
                                    $actual = $data[$i];
                                    $forecast = $wma[$i - 3];
                                    if ($forecast != 0) { // Mengabaikan prediksi dengan nilai 0
                                        $error = abs($actual - $forecast);
                                        $mape += ($error / $actual) * 100;
                                    }
                                }

                                $mape = $mape / ($count_data - 3);
                                  
                                $mse = 0;
                                for ($i = 3; $i < count($data); $i++) {
                                    if ($i >= 6) {
                                        $actual = $data[$i];
                                        $forecast = $wma[$i - 3];
                                        $squared_error = pow(($actual - $forecast), 2);
                                        $mse += $squared_error;
                                    }
                                }
                                
                                $mse = $mse / (count($data) - 6);
                                
                                $mad = 0;
                                for ($i = 3; $i < count($data); $i++) {
                                    $actual = $data[$i];
                                    $forecast = $wma[$i - 3];
                                    $deviation = abs($actual - $forecast);
                                    $mad += $deviation;
                                }
                                
                                $mad = $mad / (count($data) - 3);
                                  
                                    for ($i = 0; $i <= $count_data - 0; $i++) {
                                        echo "<tr>";
                                        echo "<td>" . ($i + 1) . "</td>";
                                        echo "<td>" . $nama[$i] . "</td>";
                                        echo "<td>" . "Rp ".  number_format($data[$i]) .  "</td>";
                                        
                                        $forecast1 = ($i >= 3) ? $wma[$i - 3] : 0;
                                        $actual1 = ($i >= 3) ? $data[$i] : 0;
                                        
                                        // MAPE
                                        $error1 = abs($actual1 - $forecast1);
                                        $mape1 = ($actual1 != 0) ? ($error1 / $actual1) * 100 : 0;
                                        
                                        // MSE
                                        $mse1 = ($actual1 != 0) ? pow(($actual1 - $forecast1), 2) : 0;
                                        
                                        // MAD
                                        $mad1 = ($actual1 != 0) ? abs($actual1 - $forecast1) : 0;
                                        
                                        echo "<td>" ."Rp ". number_format($wma[$i - 3], 2) . "</td>";
                                        echo "<td>" . number_format($mape1, 2) . "%</td>";
                                        echo "<td>" . number_format($mse1, 2) . "</td>";
                                        echo "<td>" . number_format($mad1, 2) . "</td>";
                                        
                                        echo "<td><a href='hasil_akh.php?FORCAST_HAR=" . $forcast_har[$i] . "' class='btn btn-sm btn-primary'>Tampilkan Hasil</a></td>";
                                        echo "</tr>";
                                    }
                              
                                
                              }else {
                              echo "No data available.";
                          }
                          ?>
                        
                      </tbody>
                  </table>
                  
             </div>
                    <div class="row" style="text-align: center;">
                        <div class=" col-4 card-body card mr-3 mt-4"><br><br>
                            <h4> Mape Periode</h4>
                            <?php echo number_format($mape, 2) . "%"; ?>
                        </div>
                        <div class=" col-4 card-body card mr-3 mt-4"><br>
                            <h4> Mse Periode</h4>
                            <?php echo number_format($mse, 2); ?>
                        </div>
                        <div class=" col-4 card-body card mr-3 mt-4"><br>
                            <h4> Mad Periode</h4>
                            <?php echo number_format($mad, 2) ; ?>
                        </div>
                        <div class=" col-6 card-body card mr-3 mt-4"><br>
                        <?php
                          $tgl_akh = mysqli_query ($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR DESC LIMIT 1");
                          $row2 = mysqli_fetch_assoc($tgl_akh);
                          $tgl_terakhir = $row2['TGL_HAR'];
                          ?>
                            <h4> Prediksi Data Terbaru</h4>
                            <h5><?php 
                            // echo $tgl_terakhir;
                            echo date('M-Y', strtotime('+1 month', strtotime($tgl_terakhir)));
                            ?></h5>
                            <?php echo number_format($prediksi, 2); ?>
                        </div>
                        </div>
                    </div>
              <div class="card card-body mt-4">
                
                        <center>
                        <h1 class="mt-4">Grafik Data Aktual dan Forecast</h1>
                        </center>
                        <canvas id="chart"></canvas>

                        <!-- Menambahkan sumber file JavaScript Chart.js -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <script>
                                // Inisialisasi data dan bobot
                                var data = <?php echo json_encode($data); ?>; // Konversi data menjadi format JSON
                                var wma = <?php array_unshift($wma, null,null,null); echo json_encode($wma); ?>; // Konversi hasil perhitungan WMA menjadi format JSON
                                console.log(wma);
                                var tgl = <?php echo json_encode($tgl); ?>; // Konversi tanggal menjadi format JSON
                                var dateee = <?php echo json_encode($dateee);?>

                                // Membuat grafik garis
                                var ctx = document.getElementById('chart').getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: tgl.splice(0), // Mulai dari data ke-3 sebagai label sumbu x
                                        datasets: [
                                            {
                                                label: 'Data Aktual',
                                                data: <?php echo json_encode(array_slice(array_values($data), 0)); ?>, // Mulai dari data ke-3 sebagai data grafik
                                                borderColor: 'blue',
                                                fill: false
                                            },
                                            {
                                                label: 'Forecast',
                                                data: <?php echo json_encode(array_values($wma)); ?>, // Menggunakan hasil prediksi sebagai data forecast
                                                borderColor: 'red',
                                                fill: false
                                            }
                                        ]
                                    },
                                    options: {
                                        title: {
                                            display: true,
                                            text: 'Grafik Data Aktual dan Forecast'
                                        },
                                        scales: {
                                            x: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Tanggal'
                                                },
                                                ticks: {
                                                    maxRotation: 45, // Mengatur rotasi maksimum 45 derajat
                                                    minRotation: 45 // Mengatur rotasi minimum 45 derajat
                                                }
                                            },
                                            y: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Nilai'
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>   
                    </div>
                        </div>
                    </div>  
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