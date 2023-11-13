<?php

include "./KoneksiController.php";

session_start();

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

$name_page = "Laporan Jurnal Umum";
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
$sql = "SELECT * FROM tb_jurnal tbj INNER JOIN tb_keterangan tbk ON tbj.id_keterangan = tbk.id LEFT JOIN tb_detail_jurnal USING (id_jurnal) LEFT JOIN tb_akun USING (id_akun) WHERE YEAR(tbj.created_at) = $selectedYear AND MONTH(tbj.created_at) = $selectedMonth ORDER BY tbj.id_jurnal";
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
                        if ($row['tgl_jurnal'] != $previousTanggalJurnal) {
                            // Hanya tampilkan tanggal jika tanggal_jurnal berbeda
                            echo "<td>" . $row['tgl_jurnal'] . "</td>";
                        } else {
                            // Kosongkan kolom Tanggal jika tanggal_jurnal sama dengan sebelumnya
                            echo "<td></td>";
                        }

                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td></td>";
                        echo "<td>" . $row['debet'] . "</td>";
                        echo "<td>" . $row['kredit'] . "</td>";
                        echo "</tr>";

                        // Tambahkan nilai debet dan kredit pada total
                        $totalDebet += $row['debet'];
                        $totalKredit += $row['kredit'];

                        $previousTanggalJurnal = $row['tgl_jurnal']; // Simpan tanggal_jurnal sebelumnya
                    }

                    // Setelah loop, Anda dapat menampilkan total debet dan kredit di luar loop
                    echo "<tr>";
                    echo "<td colspan='3'>Total</td>";
                    echo "<td>$totalDebet</td>";
                    echo "<td>$totalKredit</td>";
                    echo "</tr>";
                } else {
                    echo "<tr>
                    <td colspan='9'>Tidak ada data jurnal.</td>
                </tr>";
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