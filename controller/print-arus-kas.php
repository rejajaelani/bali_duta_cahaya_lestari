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
            <h3 style="padding: 0 0 5px 0;margin: 0;text-align: center;margin-bottom: 10px;">Arus Kas</h3>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>
        <table style="margin-top: -2px;">
            <thead>
                <tr>
                    <th colspan="2">Arus Kas dari Aktifitas Operasional</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal`WHERE tj.`type_transaksi` = 1 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total1 = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>" . rupiahin($row['debet']) . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>" . rupiahin(-$row['kredit']) . "</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] == $row['kredit']) {
                            $nilai = $row['debet'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>Rp. " . rupiahin($nilai) . "</td>";
                        }
                        echo "</tr>";
                        $total1 += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>" . rupiahin($total1) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
            <thead>
                <tr>
                    <th colspan="2">Arus Kas dari Aktifitas Investasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal`WHERE tj.`type_transaksi` = 2 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total2 = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>" . rupiahin($row['debet']) . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>" . rupiahin(-$row['kredit']) . "</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] == $row['kredit']) {
                            $nilai = $row['debet'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        }
                        echo "</tr>";
                        $total2 += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>Rp. " . rupiahin($total2) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
            <thead>
                <tr>
                    <th colspan="2">Arus Kas dari Aktifitas Pendanaan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal`WHERE tj.`type_transaksi` = 3 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total3 = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>" . rupiahin($row['debet']) . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>" . rupiahin(-$row['kredit']) . "</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] == $row['kredit']) {
                            $nilai = $row['debet'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        }
                        echo "</tr>";
                        $total3 += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>" . rupiahin($total3) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
            <thead>
                <tr>
                    <th colspan="2">Arus Kas dari Aktifitas Lainnya</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal`WHERE tj.`type_transaksi` = 4 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total4 = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>" . rupiahin($row['debet']) . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>" . rupiahin(-$row['kredit']) . "</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] == $row['kredit']) {
                            $nilai = $row['debet'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>" . rupiahin($nilai) . "</td>";
                        }
                        echo "</tr>";
                        $total4 += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>" . rupiahin($total4) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <table class="table table-bordered" style="font-size: 16px !important;">
            <?php
            $totalKeseluruhan = ($total1 ?? 0) + ($total2 ?? 0) + ($total3 ?? 0) + ($total4 ?? 0);
            ?>
            <tr>
                <th>Total Keseluruhan</th>
                <td><?= rupiahin($totalKeseluruhan) ?></td>
            </tr>
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