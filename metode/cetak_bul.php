<?php
error_reporting(0);
require('../fpdf184/fpdf.php');
include '../connection.php';
$result = mysqli_query($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR ASC ");

if (mysqli_num_rows($result) > 0) {
    $data = array();
    $bobot = array(0.2, 0.3, 0.5);
    $tgl = array();

    $result = mysqli_query($conn, "SELECT HARIAN.*, HASIL.* FROM HARIAN, HASIL WHERE HARIAN.ID_HAR=HASIL.ID_HAR ORDER BY TGL_HAR DESC LIMIT 120");

    $dataTerbaru = array(); // Membuat array kosong untuk menyimpan data terbaru

    while ($row = mysqli_fetch_array($result)) {
        $dataTerbaru[] = $row;
    }

    $dataTerbalik = array_reverse($dataTerbaru); // Membalikkan urutan array

    foreach ($dataTerbalik as $row) {
        $tgl[] = date('Y-m', strtotime($row['TGL_HAR']));
        $forcast_har[] = $row['FORCAST_HAR'];
        $nama[] = $row['NAMA_HAR'];
        $data[] = $row['TOTAL'];
    }

    $addTgl = date('Y-m', strtotime('+1 month', strtotime(end($tgl))));
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
    $mape = 0;
    for ($i = 3; $i <= $count_data - 1; $i++) {
        $actual = $data[$i];
        $forecast = $wma[$i - 2];
        $error = abs($actual - $forecast);
        $mape += ($error / $actual) * 100;
    }
    $mape = $mape / ($count_data - 3);

    // MSE
    $mse = 0;
    for ($i = 3; $i <= $count_data - 1; $i++) {
        $actual = $data[$i];
        $forecast = $wma[$i - 2];
        $mse += pow(($actual - $forecast), 2);
    }
    $mse = $mse / ($count_data - 3);

    // MAD
    $mad = 0;
    for ($i = 3; $i <= $count_data - 1; $i++) {
        $actual = $data[$i];
        $forecast = $wma[$i - 2];
        $mad += abs($actual - $forecast);
    }
    $mad = $mad / ($count_data - 3);

    // Membuat file PDF
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Times', 'B', 13);
    $pdf->Cell(185, 10, 'DATA FORECASTING', 0, 0, 'C');
    $pdf->Cell(10, 15, '', 0, 1);
    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(10, 7, 'NO', 1, 0, 'C');
    $pdf->Cell(30, 7, 'NAMA', 1, 0, 'C');
    $pdf->Cell(30, 7, 'PENDAPATAN', 1, 0, 'C');
    $pdf->Cell(35, 7, 'WMA', 1, 0, 'C');
    $pdf->Cell(15, 7, 'MAPE', 1, 0, 'C');
    $pdf->Cell(40, 7, 'MSE', 1, 0, 'C');
    $pdf->Cell(30, 7, 'MAD', 1, 0, 'C');

    for ($i = 0; $i <= $count_data - 0; $i++) {
        $forecast1 = ($i >= 3) ? $wma[$i - 3] : 0;
        $actual1 = ($i >= 3) ? $data[$i] : 0;

        // MAPE
        $error1 = abs($actual1 - $forecast1);
        $mape1 = ($actual1 != 0) ? ($error1 / $actual1) * 100 : 0;

        // MSE
        $mse1 = ($actual1 != 0) ? pow(($actual1 - $forecast1), 2) : 0;

        // MAD
        $mad1 = ($actual1 != 0) ? abs($actual1 - $forecast1) : 0;

        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Times', '', 10);
        $no = ($i + 1);
        $pdf->Cell(10, 6, $no++, 1, 0, 'C');
        $pdf->Cell(30, 6, $nama[$i], 1, 0, 'C');
        $pdf->Cell(30, 6, number_format($data[$i]), 1, 0, 'C');
        $pdf->Cell(35, 6, number_format($wma[$i - 3], 2), 1, 0, 'C');
        $pdf->Cell(15, 6, number_format($mape1, 2), 1, 0, 'C');
        $pdf->Cell(40, 6, number_format($mse1, 2), 1, 0, 'C');
        $pdf->Cell(30, 6, number_format($mad1, 2), 1, 0, 'C');
    }
}

$tgl_akh = mysqli_query($conn, "SELECT * FROM HARIAN ORDER BY TGL_HAR DESC LIMIT 1");
$row2 = mysqli_fetch_assoc($tgl_akh);
$tgl_terakhir = date('M-Y', strtotime('+1 month', strtotime($row2['TGL_HAR'])));
$pdf->Output('Laporan Keuangan Dan Forcast' . $tgl_terakhir.'.pdf', 'D');



?>
