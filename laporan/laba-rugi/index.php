<?php

session_start();

include "../../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../../");
    exit;
}

include "../../function/delMsg.php";

function rupiahin($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return 'Rp ' . $rupiah;
}

$name_page = "Laporan Laba Rugi";
$type_page = 2;

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
                            <h1>Laporan Laba Rugi</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Laporan</li>
                                <li class="breadcrumb-item"><a href="./">Laporan Laba Rugi</a></li>
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
                                <form action="../../controller/print-laba-rugi.php" target="_blank" method="POST">
                                    <input type="hidden" name="print-year" id="print-year" value="<?= $selectedYear ?>">
                                    <input type="hidden" name="print-month" id="print-month" value="<?= $selectedMonth ?>">
                                    <button type="submit" class="btn btn-warning float-right"><i class="fas fa-print"></i></button>
                                </form>
                            </div>
                        </div>
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
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
                                $totalPendapatanString = ($totalPendapatan == 0) ? "-" : rupiahin($totalPendapatan);
                                ?>
                                <tr>
                                    <td>Laba Kotor</td>
                                    <td></td>
                                    <td><?= $totalPendapatanString ?></td>
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
                                $totalBebanString = ($totalBeban == 0) ? "-" : rupiahin($totalBeban);
                                ?>
                                <tr>
                                    <td>Jumlah Beban</td>
                                    <td></td>
                                    <td><?= $totalBebanString ?></td>
                                </tr>
                                <tr>
                                    <?php
                                    $totalLabaBersih = 0;
                                    if ($totalBeban < 0) {
                                        $totalLabaBersih = $totalBeban + $totalPendapatan;
                                    } else {
                                        $totalLabaBersih = $totalPendapatan - $totalBeban;
                                    }
                                    $totalLabaBersihString = ($totalLabaBersih == 0) ? "-" : rupiahin($totalLabaBersih);
                                    ?>
                                    <td>Laba/Rugi Bersih</td>
                                    <td></td>
                                    <td><?= $totalLabaBersihString ?></td>
                                </tr>
                            </tbody>
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