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
            <h5 style="padding: 0 0 5px 0;margin: 0;">Arus Kas</h5>
            <h5 style="padding: 0 0 5px 0;margin: 0;">Priode <?= $namaBulan . " " . $selectedYear ?></h5>
        </div>
        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
            <thead>
                <tr>
                    <th colspan="2">Arus Kas dari Aktifitas Operasional</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_masuk ttm JOIN tb_detail_trans_masuk tdtm ON ttm.id_transaksi_masuk = tdtm.id_transaksi_masuk WHERE ttm.type_transaksi = 1 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result = mysqli_query($conn, $sql);
                $sql2 = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_keluar ttm JOIN tb_detail_trans_keluar tdtm ON ttm.id_transaksi_keluar = tdtm.id_transaksi_keluar WHERE ttm.type_transaksi = 1 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result->num_rows > 0 || $result2->num_rows > 0) {
                    $total = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>Rp. " . $row['debet'] . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>(Rp. " . $row['kredit'] . ")</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row2['keterangan'] . "</td>";
                        if ($row2['debet'] != 0 && $row2['kredit'] == 0) {
                            echo "<td>Rp. " . $row2['debet'] . "</td>";
                            $nilai = $row2['debet'];
                        } elseif ($row2['kredit'] != 0 && $row2['debet'] == 0) {
                            echo "<td>(Rp. " . $row2['kredit'] . ")</td>";
                            $nilai = -$row2['kredit'];
                        } elseif ($row2['debet'] != 0 && $row2['kredit'] != 0) {
                            $nilai = $row2['debet'] - $row2['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>Rp. " . $total . "</td>";
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
                $sql = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_masuk ttm JOIN tb_detail_trans_masuk tdtm ON ttm.id_transaksi_masuk = tdtm.id_transaksi_masuk WHERE ttm.type_transaksi = 2 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result = mysqli_query($conn, $sql);
                $sql2 = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_keluar ttm JOIN tb_detail_trans_keluar tdtm ON ttm.id_transaksi_keluar = tdtm.id_transaksi_keluar WHERE ttm.type_transaksi = 2 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result->num_rows > 0 || $result2->num_rows > 0) {
                    $total = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>Rp. " . $row['debet'] . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>(Rp. " . $row['kredit'] . ")</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row2['keterangan'] . "</td>";
                        if ($row2['debet'] != 0 && $row2['kredit'] == 0) {
                            echo "<td>Rp. " . $row2['debet'] . "</td>";
                            $nilai = $row2['debet'];
                        } elseif ($row2['kredit'] != 0 && $row2['debet'] == 0) {
                            echo "<td>(Rp. " . $row2['kredit'] . ")</td>";
                            $nilai = -$row2['kredit'];
                        } elseif ($row2['debet'] != 0 && $row2['kredit'] != 0) {
                            $nilai = $row2['debet'] - $row2['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>Rp. " . $total . "</td>";
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
                $sql = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_masuk ttm JOIN tb_detail_trans_masuk tdtm ON ttm.id_transaksi_masuk = tdtm.id_transaksi_masuk WHERE ttm.type_transaksi = 3 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result = mysqli_query($conn, $sql);
                $sql2 = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_keluar ttm JOIN tb_detail_trans_keluar tdtm ON ttm.id_transaksi_keluar = tdtm.id_transaksi_keluar WHERE ttm.type_transaksi = 3 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result->num_rows > 0 || $result2->num_rows > 0) {
                    $total = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>Rp. " . $row['debet'] . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>(Rp. " . $row['kredit'] . ")</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row2['keterangan'] . "</td>";
                        if ($row2['debet'] != 0 && $row2['kredit'] == 0) {
                            echo "<td>Rp. " . $row2['debet'] . "</td>";
                            $nilai = $row2['debet'];
                        } elseif ($row2['kredit'] != 0 && $row2['debet'] == 0) {
                            echo "<td>(Rp. " . $row2['kredit'] . ")</td>";
                            $nilai = -$row2['kredit'];
                        } elseif ($row2['debet'] != 0 && $row2['kredit'] != 0) {
                            $nilai = $row2['debet'] - $row2['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>Rp. " . $total . "</td>";
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
                $sql = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_masuk ttm JOIN tb_detail_trans_masuk tdtm ON ttm.id_transaksi_masuk = tdtm.id_transaksi_masuk WHERE ttm.type_transaksi = 4 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result = mysqli_query($conn, $sql);
                $sql2 = "SELECT ttm.`keterangan`, DATE_FORMAT(tdtm.created_at, '%Y-%m') AS bulan_transaksi, SUM(tdtm.debet) AS debet, SUM(tdtm.kredit) AS kredit FROM tb_transaksi_keluar ttm JOIN tb_detail_trans_keluar tdtm ON ttm.id_transaksi_keluar = tdtm.id_transaksi_keluar WHERE ttm.type_transaksi = 4 AND YEAR(tdtm.created_at) = $selectedYear AND MONTH(tdtm.created_at) = $selectedMonth GROUP BY ttm.type_transaksi, DATE_FORMAT(tdtm.created_at, '%Y-%m')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result->num_rows > 0 || $result2->num_rows > 0) {
                    $total = 0;
                    $nilai = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row['keterangan'] == $row['keterangan']) {
                        }
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['debet'] != 0 && $row['kredit'] == 0) {
                            echo "<td>Rp. " . $row['debet'] . "</td>";
                            $nilai = $row['debet'];
                        } elseif ($row['kredit'] != 0 && $row['debet'] == 0) {
                            echo "<td>(Rp. " . $row['kredit'] . ")</td>";
                            $nilai = -$row['kredit'];
                        } elseif ($row['debet'] != 0 && $row['kredit'] != 0) {
                            $nilai = $row['debet'] - $row['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row2['keterangan'] . "</td>";
                        if ($row2['debet'] != 0 && $row2['kredit'] == 0) {
                            echo "<td>Rp. " . $row2['debet'] . "</td>";
                            $nilai = $row2['debet'];
                        } elseif ($row2['kredit'] != 0 && $row2['debet'] == 0) {
                            echo "<td>(Rp. " . $row2['kredit'] . ")</td>";
                            $nilai = -$row2['kredit'];
                        } elseif ($row2['debet'] != 0 && $row2['kredit'] != 0) {
                            $nilai = $row2['debet'] - $row2['kredit'];
                            echo "<td>Rp. " . $nilai . "</td>";
                        }
                        echo "</tr>";
                        $total += $nilai;
                    }
                    echo "<tr>";
                    echo "<td>Total</td>";
                    echo "<td>Rp. " . $total . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data arus kas.</td></tr>";
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