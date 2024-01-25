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
        <table class="table table-bordered d-none" style="font-size: 16px !important;display: none;">
            <?php
            $sqlSaldoAwal = "SELECT SUM(tdj.`debet`) AS debet FROM tb_detail_jurnal tdj LEFT OUTER JOIN tb_akun ta ON ta.`id_akun` = tdj.`id_akun` WHERE ta.`nama` = 'Kas' AND tdj.`id_jurnal` = (SELECT tdj.`id_jurnal` FROM tb_detail_jurnal tdj LEFT OUTER JOIN tb_akun ta ON ta.`id_akun` = tdj.`id_akun` WHERE ta.`nama` = 'Modal') GROUP BY tdj.`id_jurnal`";
            $resultSaldoAwal = mysqli_query($conn, $sqlSaldoAwal);
            $rowSaldoAwal = $resultSaldoAwal->fetch_assoc()
            ?>
            <tr>
                <th colspan="2">Saldo Awal Kas</th>
                <td style="width: 300px !important;font-weight: bold;"><?= rupiahin($rowSaldoAwal['debet']) ?></td>
            </tr>
        </table>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;margin-top: -2px;">
            <thead>
                <tr>
                    <th colspan="3">Arus Kas dari Aktifitas Operasional</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal` LEFT OUTER JOIN tb_akun ta ON ta.`id_akun` = tdj.`id_akun` WHERE tj.`type_transaksi` = 1 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth AND ta.`nama` = 'Kas' AND tdj.`debet` != 0 GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result = mysqli_query($conn, $sql);
                $sql2 = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal` LEFT OUTER JOIN tb_akun ta ON ta.`id_akun` = tdj.`id_akun` WHERE tj.`type_transaksi` = 1 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth AND ta.`nama` = 'Kas' AND tdj.`kredit` != 0 GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result2 = mysqli_query($conn, $sql2);
                if ($result->num_rows > 0 || $result2->num_rows > 0) {
                    $total1 = 0;
                    $nilaiDebet = 0;
                    $nilaiKredit = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        echo "<td style='width: 300px !important;'>" . rupiahin($row['debet']) . "</td>";
                        echo "<td></td>";
                        echo "</tr>";
                        $nilaiDebet += $row['debet'];
                    }
                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        if ($row2['keterangan'] == $row2['keterangan']) {
                        }
                        echo "<td>" . $row2['keterangan'] . "</td>";
                        echo "<td style='width: 300px !important;'>" . rupiahin(-$row2['kredit']) . "</td>";
                        echo "<td></td>";
                        echo "</tr>";
                        $nilaiKredit += $row2['kredit'];
                    }
                    $total1 = $nilaiDebet - $nilaiKredit;
                    echo "<tr>";
                    echo "<td colspan='2'>Total</td>";
                    echo "<td style='width: 300px !important;'>" . rupiahin($total1) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='3'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
            <thead>
                <tr>
                    <th colspan="3">Arus Kas dari Aktifitas Investasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal` WHERE tj.`type_transaksi` = 2 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` DESC";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $total2 = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        echo "<td style='width: 300px !important;'>" . "(" . rupiahin($row['kredit']) . ")" . "</td>";
                        echo "</tr>";
                        $total2 += $row['kredit'];
                    }
                    echo "<tr>";
                    echo "<td colspan='2'>Total</td>";
                    echo "<td style='width: 300px !important;'>Rp. " . rupiahin($total2) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='3'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
            <thead>
                <tr>
                    <th colspan="3">Arus Kas dari Aktifitas Pendanaan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal` LEFT OUTER JOIN tb_akun ta ON ta.`id_akun` = tdj.`id_akun` WHERE tj.`type_transaksi` = 3 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth AND ta.`nama` = 'Modal' OR ta.`nama` = 'Utang Bank' GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` ASC";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    $totalModal = 0;
                    $totalPrive = 0;
                    $nilaiModal = 0;
                    $nilaiKasKredit = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>" . rupiahin(-$row['debet']) . "</td>";
                            echo "<td></td>";
                            $nilaiModal = -$row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>" . rupiahin($row['kredit']) . "</td>";
                            echo "<td></td>";
                            $nilaiModal = $row['kredit'];
                        } elseif ($row['debet'] == $row['kredit']) {
                            $nilaiModal = $row['debet'];
                            echo "<td>" . rupiahin($nilaiModal) . "</td>";
                            echo "<td></td>";
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilaiModal = $row['debet'] - $row['kredit'];
                            echo "<td>" . rupiahin($nilaiModal) . "</td>";
                            echo "<td></td>";
                        }
                        echo "</tr>";
                        $nilaiKasKredit += $row['kredit'];
                        $totalModal += $nilaiModal;
                    }
                    $sqlPrive = "SELECT tj.`keterangan`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') AS bulan_transaksi, SUM(tdj.`debet`) AS debet, SUM(tdj.`kredit`) AS kredit FROM tb_jurnal tj JOIN tb_detail_jurnal tdj ON tj.`id_jurnal` = tdj.`id_jurnal` LEFT OUTER JOIN tb_akun ta ON ta.`id_akun` = tdj.`id_akun` WHERE tj.`type_transaksi` = 3 AND YEAR(tdj.created_at) = $selectedYear AND MONTH(tdj.created_at) = $selectedMonth AND ta.`nama` = 'Prive' GROUP BY tj.`id_jurnal`, DATE_FORMAT(tdj.`created_at`, '%Y-%m') ORDER BY tj.`created_at` ASC";
                    $resultPrive = mysqli_query($conn, $sqlPrive);
                    $nilaiPrive = 0;
                    while ($row = $resultPrive->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>" . rupiahin($row['debet']) . "</td>";
                            echo "<td></td>";
                            $nilaiPrive = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>" . rupiahin(-$row['kredit']) . "</td>";
                            echo "<td></td>";
                            $nilaiPrive = -$row['kredit'];
                        } elseif ($row['debet'] == $row['kredit']) {
                            $nilaiPrive = $row['debet'];
                            echo "<td>" . rupiahin($nilaiPrive) . "</td>";
                            echo "<td></td>";
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilaiPrive = $row['debet'] - $row['kredit'];
                            echo "<td>" . rupiahin($nilaiPrive) . "</td>";
                            echo "<td></td>";
                        }
                        echo "</tr>";
                        $totalPrive += $nilaiPrive;
                    }
                    $totalAkhirPendanaan = $totalModal - $totalPrive;
                    echo "<tr>";
                    echo "<td colspan='2'>Total</td>";
                    echo "<td style='width: 300px !important;'>" . rupiahin($totalAkhirPendanaan) . "</td>";
                    echo "</tr>";
                    $total3 = $totalAkhirPendanaan;
                } else {
                    echo "<tr><td colspan='3'>Tidak ada data arus kas.</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <!-- <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
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
                        </table> -->
        <table class="table table-bordered" style="font-size: 16px !important;">
            <?php
            $totalKeseluruhan = (($total1 ?? 0) + ($total3 ?? 0)) - ($total2 ?? 0);
            ?>
            <tr>
                <th colspan="2">Total Saldo Akhir</th>
                <td style="width: 300px !important;"><?= rupiahin($totalKeseluruhan) ?></td>
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