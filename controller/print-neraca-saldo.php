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
        <div class="kop" style="margin: 20px 1%;padding: 5px;display: flex;width: 98%;justify-content: center;gap: 20px;border: 1px solid black;">
            <div class="image">
                <img src="../images/logo.png" width="50" height="50">
            </div>
            <div class="text">
                <h3 style="padding: 0 0 5px 0;margin: 0;">PT. Bali Duta Cahaya Lestari</h3>
                <p style="padding: 0 0 5px 0;margin: 0;">JL Teuku Umar, Denpasar, Bali, 80113, Indonesia</p>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <h3 style="padding: 0 0 5px 0;margin: 0;text-align: center;margin-bottom: 10px;">Neraca Saldo</h3>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>
        <table style="margin-top: -2px;">
            <thead>
                <tr>
                    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $jumDebet = 0;
                    $jumKredit = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_akun'] . "</td>";
                        echo "<td>" . $row['Akun_Name'] . "</td>";
                        if ($row['Debet'] != 0 && $row['Kredit'] != 0) {
                            $Hasil = $row['Debet'] - $row['Kredit'];
                            if ($Hasil < 0) {
                                echo "<td></td>";
                                echo "<td>" . rupiahin($Hasil) . "</td>";
                                $jumKredit += $Hasil;
                            } else {
                                echo "<td>" . rupiahin($Hasil) . "</td>";
                                echo "<td></td>";
                                $jumDebet += $Hasil;
                            }
                        } elseif ($row['Debet'] != 0 && $row['Kredit'] == 0) {
                            echo "<td>" . rupiahin($row['Debet']) . "</td>";
                            echo "<td></td>";
                            $jumDebet += $row['Debet'];
                        } elseif ($row['Debet'] == 0 && $row['Kredit'] != 0) {
                            echo "<td></td>";
                            echo "<td>" . rupiahin($row['Kredit']) . "</td>";
                            $jumKredit += $row['Kredit'];
                        }
                        echo "</tr>";
                    }
                    $jumDebetString = rupiahin($jumDebet);
                    $jumKreditString = rupiahin($jumKredit);
                ?>
                    <tr>
                        <td colspan="2" class="font-weight-bold">Total</td>
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