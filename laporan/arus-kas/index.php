<?php

session_start();

include "../../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../../");
    exit;
}

include "../../function/delMsg.php";

$name_page = "Laporan Arus Kas";
$type_page = 2;

function rupiahin($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return 'Rp ' . $rupiah;
}

$currentMonth = date('m');
$currentYear = date('Y');

if (isset($_GET['src-year'])) {
    $selectedYear = intval($_GET['src-year']);
} else {
    $selectedYear = intval($currentYear);
}

if (isset($_GET['src-month'])) {
    $selectedMonth = intval($_GET['src-month']);
} else {
    $selectedMonth = intval($currentMonth);
}

?>

<?php include "../../assets/template/header.php" ?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php include "../../assets/template/navbar.php" ?>

        <?php include "../../assets/template/side-bar.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <?php
                        if (!empty($_SESSION['msg'])) {
                        ?>
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> <?= $_SESSION['msg']['key'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (!empty($_SESSION['msg-w'])) {
                        ?>
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> <?= $_SESSION['msg-w']['key'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (!empty($_SESSION['msg-f'])) {
                        ?>
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> <?= $_SESSION['msg-f']['key'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-12">
                            <h1>Laporan Arus Kas</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Laporan</li>
                                <li class="breadcrumb-item"><a href="./">Laporan Arus Kas</a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <form action="" method="GET">
                                    <div class="form-row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="form-control" name="src-year" id="src-year">
                                                    <option <?= ($selectedYear == 2025) ? 'selected' : '' ?>>2025</option>
                                                    <option <?= ($selectedYear == 2024) ? 'selected' : '' ?>>2024</option>
                                                    <option <?= ($selectedYear == 2023) ? 'selected' : '' ?>>2023</option>
                                                    <option <?= ($selectedYear == 2022) ? 'selected' : '' ?>>2022</option>
                                                    <option <?= ($selectedYear == 2021) ? 'selected' : '' ?>>2021</option>
                                                    <option <?= ($selectedYear == 2020) ? 'selected' : '' ?>>2020</option>
                                                    <option <?= ($selectedYear == 2019) ? 'selected' : '' ?>>2019</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="form-control" name="src-month" id="src-month">
                                                    <option <?= ($selectedMonth == 1) ? 'selected' : '' ?> value="1">January</option>
                                                    <option <?= ($selectedMonth == 2) ? 'selected' : '' ?> value="2">February</option>
                                                    <option <?= ($selectedMonth == 3) ? 'selected' : '' ?> value="3">March</option>
                                                    <option <?= ($selectedMonth == 4) ? 'selected' : '' ?> value="4">April</option>
                                                    <option <?= ($selectedMonth == 5) ? 'selected' : '' ?> value="5">May</option>
                                                    <option <?= ($selectedMonth == 6) ? 'selected' : '' ?> value="6">June</option>
                                                    <option <?= ($selectedMonth == 7) ? 'selected' : '' ?> value="7">July</option>
                                                    <option <?= ($selectedMonth == 8) ? 'selected' : '' ?> value="8">August</option>
                                                    <option <?= ($selectedMonth == 9) ? 'selected' : '' ?> value="9">September</option>
                                                    <option <?= ($selectedMonth == 10) ? 'selected' : '' ?> value="10">October</option>
                                                    <option <?= ($selectedMonth == 11) ? 'selected' : '' ?> value="11">November</option>
                                                    <option <?= ($selectedMonth == 12) ? 'selected' : '' ?> value="12">December</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-danger">Cari</button>
                                            <a href="./" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-8">
                                <form action="../../controller/print-arus-kas.php" target="_blank" method="POST">
                                    <input type="hidden" name="print-year" id="print-year" value="<?= $selectedYear ?>">
                                    <input type="hidden" name="print-month" id="print-month" value="<?= $selectedMonth ?>">
                                    <button type="submit" class="btn btn-warning float-right"><i class="fas fa-print"></i></button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-bordered d-none" style="font-size: 16px !important;">
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
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
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
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Jquery -->
    <script src="../../assets/js/jQuery.js"></script>
    <!-- Data Table -->
    <script src="../../assets/js/dataTable.min.js"></script>
    <script src="../../assets/js/dataTable.bootstrap4.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <!-- <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script> -->
</body>

</html>