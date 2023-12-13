<?php

include "./KoneksiController.php";

session_start();

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

$name_page = "Laporan Laba Rugi";
$type_page = 2;

function rupiahin($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return 'Rp ' . $rupiah;
}

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
$sql1 = "SELECT ta.nama AS Akun_Name, tj.`keterangan` AS Keterangan_Name, SUM(tdj.`debet`) AS Debet, SUM(tdj.kredit) AS Kredit, SUM(tdj.`debet`) - SUM(tdj.kredit) AS Jumlah FROM tb_akun ta 
INNER JOIN tb_detail_jurnal tdj ON ta.`id_akun` = tdj.`id_akun` 
INNER JOIN tb_jurnal tj ON tdj.`id_jurnal` = tj.`id_jurnal`
WHERE ta.nama LIKE '%Pendapatan%' OR ta.nama LIKE '%Penjualan%' AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth
GROUP BY Keterangan_Name
ORDER BY tdj.created_at ASC";
$sql2 = "SELECT ta.nama AS Akun_Name, tj.`keterangan` AS Keterangan_Name, SUM(tdj.`debet`) AS Debet, SUM(tdj.kredit) AS Kredit, SUM(tdj.`debet`) - SUM(tdj.kredit) AS Jumlah FROM tb_akun ta 
INNER JOIN tb_detail_jurnal tdj ON ta.`id_akun` = tdj.`id_akun` 
INNER JOIN tb_jurnal tj ON tdj.`id_jurnal` = tj.`id_jurnal`
WHERE ta.nama LIKE '%Beban%' AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth  
GROUP BY Keterangan_Name";
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);

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
            <h5 style="padding: 0 0 5px 0;margin: 0;">Laba Rugi</h5>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>

        <table>
            <tbody>
                <tr>
                    <td>Penjualan</td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $totalPendapatan = 0;
                while ($row = mysqli_fetch_assoc($result1)) {
                ?>
                    <tr>
                        <td style="padding-left: 50px;"><?= $row['Keterangan_Name'] ?></td>
                        <?php
                        $nilai = 0;
                        if ($row['Jumlah'] == 0) {
                            $nilai = $row['Debet'];
                        ?>
                            <td><?= rupiahin($row['Debet']) ?></td>
                        <?php } else if ($row['Jumlah'] < 0) {
                            $nilai = $row['Kredit']; ?>
                            <td><?= rupiahin($row['Kredit']) ?></td>
                        <?php } else {
                            $nilai = $row['Jumlah'] ?>
                            <td><?= rupiahin($row['Jumlah']) ?></td>
                        <?php } ?>
                        <td></td>
                    </tr>
                <?php
                    $totalPendapatan += $nilai;
                }
                ?>
                <tr>
                    <td>Laba Kotor</td>
                    <td></td>
                    <td><?= rupiahin($totalPendapatan) ?></td>
                </tr>
                <tr>
                    <td>Beban</td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $totalBeban = 0;
                while ($row = mysqli_fetch_assoc($result2)) {
                ?>
                    <tr>
                        <td style="padding-left: 50px;"><?= $row['Keterangan_Name'] ?></td>
                        <?php
                        $nilaiB = 0;
                        if ($row['Jumlah'] == 0) {
                            $nilaiB = -$row['Debet'];
                        ?>
                            <td><?= rupiahin(-$row['Debet']) ?></td>
                        <?php } else if ($row['Jumlah'] < 0) {
                            $nilaiB = -$row['Kredit']; ?>
                            <td><?= rupiahin(-$row['Kredit']) ?></td>
                        <?php } else {
                            $nilaiB = -$row['Jumlah'] ?>
                            <td><?= rupiahin(-$row['Jumlah']) ?></td>
                        <?php } ?>
                        <td></td>
                    </tr>
                <?php
                    $totalBeban += $nilaiB;
                }
                ?>
                <tr>
                    <td>Jumlah Beban</td>
                    <td></td>
                    <td><?= rupiahin($totalBeban) ?></td>
                </tr>
                <tr>
                    <?php
                    $totalLabaBersih = 0;
                    if ($totalBeban < 0) {
                        $totalLabaBersih = $totalBeban + $totalPendapatan;
                    } else {
                        $totalLabaBersih = $totalPendapatan - $totalBeban;
                    }
                    ?>
                    <td>Laba/Rugi Bersih</td>
                    <td></td>
                    <td><?= rupiahin($totalLabaBersih) ?></td>
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