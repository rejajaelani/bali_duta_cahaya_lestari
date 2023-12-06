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
$sql = "SELECT CAST(tdtm.created_at AS DATE) AS Tanggal, ta.nama AS Akun_Name, SUM(tdtm.debet) AS Debet, SUM(tdtm.kredit) AS Kredit 
FROM tb_jurnal ttm 
LEFT JOIN tb_detail_jurnal tdtm ON ttm.id_jurnal = tdtm.id_jurnal 
LEFT JOIN tb_akun ta ON tdtm.id_akun = ta.id_akun 
WHERE YEAR(ttm.created_at) = $selectedYear AND MONTH(ttm.created_at) = $selectedMonth 
GROUP BY Tanggal, tdtm.id_akun
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
            <h5 style="padding: 0 0 5px 0;margin: 0;">Jurnal Umum</h5>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Akun</th>
                    <th>Ref</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 0;
                    $previousTanggalJurnal = null; // Inisialisasi variabel untuk melacak tanggal_jurnal sebelumnya

                    $totalDebet = 0;
                    $totalKredit = 0;

                    while ($row = $result->fetch_assoc()) {
                        $no++;
                        echo "<tr>";
                        if ($row['Tanggal'] != $previousTanggalJurnal) {
                            // Hanya tampilkan tanggal jika tanggal_jurnal berbeda
                            echo "<td>" . $row['Tanggal'] . "</td>";
                        } else {
                            // Kosongkan kolom Tanggal jika tanggal_jurnal sama dengan sebelumnya
                            echo "<td></td>";
                        }
                        $DebetString = ($row['Debet'] == 0) ? "-" : rupiahin($row['Debet']);
                        $KreditString = ($row['Kredit'] == 0) ? "-" : rupiahin($row['Kredit']);
                        echo "<td>" . $row['Akun_Name'] . "</td>";
                        echo "<td></td>";
                        echo "<td>" . $DebetString . "</td>";
                        echo "<td>" . $KreditString . "</td>";
                        echo "</tr>";

                        // Tambahkan nilai debet dan kredit pada total
                        $totalDebet += $row['Debet'];
                        $totalKredit += $row['Kredit'];

                        $previousTanggalJurnal = $row['Tanggal']; // Simpan tanggal_jurnal sebelumnya
                    }

                    // Setelah loop, Anda dapat menampilkan total debet dan kredit di luar loop
                    $debetT = ($totalDebet == 0) ? "-" : rupiahin($totalDebet);
                    $kreditT = ($totalKredit == 0) ? "-" : rupiahin($totalKredit);
                    echo "<tr>";
                    echo "<td colspan='3'>Total</td>";
                    echo "<td>$debetT</td>";
                    echo "<td>$kreditT</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data jurnal.</td></tr>";
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