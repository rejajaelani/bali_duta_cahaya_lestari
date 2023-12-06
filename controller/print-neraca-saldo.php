<?php

include "./KoneksiController.php";

session_start();

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

$name_page = "Laporan Jurnal Umum";
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
$sql = "SELECT CAST(tdtm.created_at AS DATE) AS Tanggal, ta.id_akun, ta.nama AS Akun_Name, SUM(tdtm.debet) AS Debet, SUM(tdtm.kredit) AS Kredit 
FROM tb_jurnal ttm 
LEFT JOIN tb_detail_jurnal tdtm ON ttm.id_jurnal = tdtm.id_jurnal 
LEFT JOIN tb_akun ta ON tdtm.id_akun = ta.id_akun 
WHERE YEAR(ttm.created_at) = $selectedYear AND MONTH(ttm.created_at) = $selectedMonth 
GROUP BY tdtm.id_akun
ORDER BY tdtm.id";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Laporan | Jurnal Umum</title>

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
            <h5 style="padding: 0 0 5px 0;margin: 0;">Neraca Saldo</h5>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $jumDebet = 0;
                    $jumKredit = 0;
                    while ($row = $result->fetch_assoc()) {
                        $DebetString = ($row['Debet'] == 0) ? "-" : rupiahin($row['Debet']);
                        $KreditString = ($row['Kredit'] == 0) ? "-" : rupiahin($row['Kredit']);
                        echo "<tr>";
                        echo "<td>" . $row['id_akun'] . "</td>";
                        echo "<td>" . $row['Akun_Name'] . "</td>";
                        echo "<td>" . $DebetString . "</td>";
                        echo "<td>" . $KreditString . "</td>";
                        echo "</tr>";
                        $jumDebet += $row['Debet'];
                        $jumKredit += $row['Kredit'];
                    }
                    $jumDebetString = ($jumDebet == 0) ? "-" : rupiahin($jumDebet);
                    $jumKreditString = ($jumKredit == 0) ? "-" : rupiahin($jumKredit);
                ?>
                    <tr>
                        <td colspan="2" class="font-weight-bold">Jumlah</td>
                        <td><?= $jumDebetString ?></td>
                        <td><?= $jumKreditString ?></td>
                    </tr>
                <?php
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data neraca saldo.</td></tr>";
                }
                ?>
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