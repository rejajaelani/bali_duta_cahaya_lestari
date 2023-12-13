<?php

session_start();

include "../../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../../");
    exit;
}

include "../../function/delMsg.php";

$name_page = "Laporan Neraca Saldo";
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
                            <h1>Laporan Neraca Saldo</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Laporan</li>
                                <li class="breadcrumb-item"><a href="./">Laporan Neraca Saldo</a></li>
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
                                <form action="../../controller/print-neraca-saldo.php" target="_blank" method="POST">
                                    <input type="hidden" name="print-year" id="print-year" value="<?= $selectedYear ?>">
                                    <input type="hidden" name="print-month" id="print-month" value="<?= $selectedMonth ?>">
                                    <button type="submit" class="btn btn-warning float-right"><i class="fas fa-print"></i></button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped" style="font-size: 14px !important;">
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
                                    $jumHasil = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $Hasil = $row['Debet'] - $row['Kredit'];
                                        $HasilString = rupiahin($Hasil);
                                        echo "<tr>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['Akun_Name'] . "</td>";
                                        echo "<td>" . $HasilString . "</td>";
                                        echo "</tr>";
                                        $jumHasil += $Hasil;
                                    }
                                    $jumHasilString = rupiahin($jumHasil);
                                ?>
                                    <tr>
                                        <td colspan="2" class="font-weight-bold">Total</td>
                                        <td><?= $jumHasilString ?></td>
                                    </tr>
                                <?php
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data neraca saldo.</td></tr>";
                                }
                                ?>
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