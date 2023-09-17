<?php
// Menggabungkan FPDF dan FPDI
require('../fpdf184/fpdf.php');
require('../FPDI/src/autoload.php');

use setasign\Fpdi\Fpdi;

// Mendefinisikan class PDF yang mewarisi Fpdi
class PDF extends Fpdi
{
    // Fungsi untuk membuat grafik
    function DrawChart($data, $labels)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Grafik Data', 0, 1, 'C');

        // Mengatur ukuran dan posisi grafik
        $chartWidth = 180;
        $chartHeight = 100;
        $chartX = ($this->GetPageWidth() - $chartWidth) / 2;
        $chartY = 40;

        // Daftar warna yang akan digunakan
        $colors = array('red', 'blue', 'green', 'orange', 'purple');

        // Menggambar sumbu x dan sumbu y
        $this->Line($chartX, $chartY + $chartHeight, $chartX + $chartWidth, $chartY + $chartHeight); // Sumbu x
        $this->Line($chartX, $chartY, $chartX, $chartY + $chartHeight); // Sumbu y

        // Menggambar garis grafik berdasarkan data
        $dataCount = count($data);
        $barWidth = $chartWidth / $dataCount;
        $barHeightRatio = $chartHeight / max($data); // Faktor untuk mengubah data ke tinggi grafik

        for ($i = 0; $i < $dataCount; $i++) {
            $x1 = $chartX + $i * $barWidth;
            $x2 = $x1 + $barWidth;
            $y1 = $chartY + $chartHeight;
            $y2 = $y1 - $data[$i] * $barHeightRatio;

            // Menentukan warna untuk setiap baris
            $colorIndex = $i % count($colors);
            $color = $colors[$colorIndex];

            $this->SetFillColor($color); // Mengatur warna isi persegi panjang
            $this->Rect($x1, $y2, $barWidth, $y1 - $y2, 'F'); // Menggambar persegi panjang sebagai grafik
        }

        // Menulis label pada sumbu x
        $labelX = $chartX + $barWidth / 2;
        $labelY = $chartY + $chartHeight + 10;
        $this->SetFont('Arial', 'B', 8);
        foreach ($labels as $label) {
            $this->Cell($barWidth, 10, $label, 0, 0, 'C');
            $labelX += $barWidth;
        }
    }
}

// Membuat objek PDF
$pdf = new PDF();

// Menambahkan halaman pertama
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Data', 0, 1, 'C');

// Menambahkan tabel data
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(40, 10, 'Pendapatan', 1, 1, 'C');
$data = [
    215000, 15000, 220000, 40000, 145000, 40000, 235000, 220000, 95000, 195000, 225000,
    90000, 0, 30000, 180000, 75000, 100000, 70000, 0, 220000, 105000, 175000, 215000,
    185000, 15000, 130000, 105000, 0, 0, 155000, 105000
];
$tanggal = [
    '2021-07-01', '2021-07-02', '2021-07-03', '2021-07-04', '2021-07-05', '2021-07-06', '2021-07-07',
    '2021-07-08', '2021-07-09', '2021-07-10', '2021-07-11', '2021-07-12', '2021-07-13', '2021-07-14',
    '2021-07-15', '2021-07-16', '2021-07-17', '2021-07-18', '2021-07-19', '2021-07-20', '2021-07-21',
    '2021-07-22', '2021-07-23', '2021-07-24', '2021-07-25', '2021-07-26', '2021-07-27', '2021-07-28',
    '2021-07-29', '2021-07-30', '2021-07-31'
];
for ($i = 0; $i < count($data); $i++) {
    $pdf->Cell(40, 10, $tanggal[$i], 1, 0, 'C');
    $pdf->Cell(40, 10, $data[$i], 1, 1, 'C');
}

// Menambahkan grafik
$pdf->DrawChart($data, $tanggal);

// Output PDF
$pdf->Output('');

?>
