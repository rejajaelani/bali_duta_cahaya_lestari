<?php

include "./KoneksiController.php";

session_start();

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

$name_page = "Laporan Laba Rugi";
$type_page = 2;

if (isset($_POST['print-year'])) {
    $selectedYear = intval($_POST['print-year']);
} else {
    $selectedYear = 0;
}

if (isset($_POST['print-month'])) {
    $selectedMonth = intval($_POST['print-month']);
} else {
    $selectedMonth = 0;
}

$namaBulan = date("F", mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));

// Inisialisasi variabel SQL
$sql1 = "SELECT ta.nama AS Akun_Name, tj.`keterangan` AS Keterangan_Name, SUM(tdj.`debet`) - SUM(tdj.kredit) AS Jumlah FROM tb_akun ta 
INNER JOIN tb_detail_jurnal tdj ON ta.`id_akun` = tdj.`id_akun` 
INNER JOIN tb_jurnal tj ON tdj.`id_jurnal` = tj.`id_jurnal` 
WHERE ta.nama LIKE '%Pendapatan%' AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth  
GROUP BY Keterangan_Name
ORDER BY tdj.created_at ASC";
$sql2 = "SELECT ta.nama AS Akun_Name, tj.`keterangan` AS Keterangan_Name, SUM(tdj.`debet`) - SUM(tdj.kredit) AS Jumlah FROM tb_akun ta 
INNER JOIN tb_detail_jurnal tdj ON ta.`id_akun` = tdj.`id_akun` 
INNER JOIN tb_jurnal tj ON tdj.`id_jurnal` = tj.`id_jurnal` 
WHERE ta.nama LIKE '%Beban%' AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth  
GROUP BY Keterangan_Name";
$sql3 = "SELECT ta.nama AS Akun_Name, tj.`keterangan` AS Keterangan_Name, SUM(tdj.`debet`) - SUM(tdj.kredit) AS Jumlah FROM tb_akun ta 
INNER JOIN tb_detail_jurnal tdj ON ta.`id_akun` = tdj.`id_akun` 
INNER JOIN tb_jurnal tj ON tdj.`id_jurnal` = tj.`id_jurnal` 
WHERE ta.nama LIKE '%Modal%' AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth  
GROUP BY Keterangan_Name";
$sql4 = "SELECT ta.nama AS Akun_Name, tj.`keterangan` AS Keterangan_Name, SUM(tdj.`debet`) - SUM(tdj.kredit) AS Jumlah FROM tb_akun ta 
INNER JOIN tb_detail_jurnal tdj ON ta.`id_akun` = tdj.`id_akun` 
INNER JOIN tb_jurnal tj ON tdj.`id_jurnal` = tj.`id_jurnal` 
WHERE ta.nama LIKE '%Prive%' AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth  
GROUP BY Keterangan_Name";
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);
$result4 = mysqli_query($conn, $sql4);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Laporan | <?= $name_page ?></title>

    <style>
        table {
            margin-top: 20px;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        th,
        td {
            text-align: left;
            padding: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="kop" style="text-align: center;">
            <h5 style="padding: 0 0 5px 0;margin: 0;">PT. Bali Duta Cahaya Lestari</h5>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Perubahan Modal</h5>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>

        <table>
            <tbody>
                <?php
                $modalAwal = 0;
                while ($row = mysqli_fetch_assoc($result3)) { ?>
                    <tr>
                        <td><?= $row['Keterangan_Name'] ?> (Awal)</td>
                        <td><?= $row['Jumlah'] ?></td>
                    </tr>
                <?php
                    $modalAwal += $row['Jumlah'];
                }
                ?>
                <?php
                $totalPendapatan = 0;
                while ($row = mysqli_fetch_assoc($result1)) {
                    $totalPendapatan += $row['Jumlah'];
                }
                $totalBeban = 0;
                while ($row = mysqli_fetch_assoc($result2)) {
                    $totalBeban += $row['Jumlah'];
                }
                $totalModalAwal = $modalAwal + ($totalPendapatan - $totalBeban)
                ?>
                <tr>
                    <td>Laba Bersih</td>
                    <td><?= $totalPendapatan - $totalBeban ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-top: 2px solid black;"><?= $totalModalAwal ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $prive = 0;
                while ($row = mysqli_fetch_assoc($result4)) { ?>
                    <tr>
                        <td><?= $row['Keterangan_Name'] ?></td>
                        <td><?= $row['Jumlah'] ?></td>
                    </tr>
                <?php
                    $prive += $row['Jumlah'];
                }
                ?>
                <tr>
                    <td>Modal Akhir</td>
                    <td><?= $totalModalAwal - $prive ?></td>
                </tr>
            </tbody>
        </table>


    </div>

    <!-- Script JavaScript untuk Cetak -->
    <script>
        // Mencetak halaman saat dokumen selesai dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>