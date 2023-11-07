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

// Inisialisasi variabel SQL
$sql = "SELECT ta.*, SUM(tdtm.`debet`) AS Debet, SUM(tdtm.`kredit`) AS Kredit FROM tb_akun ta INNER JOIN tb_detail_trans_masuk tdtm ON ta.`id_akun` = tdtm.`id_akun` GROUP BY ta.`id_akun` ORDER BY ta.`id_akun` ASC";
$sql2 = "SELECT ta.*, SUM(tdtm.`debet`) AS Debet, SUM(tdtm.`kredit`) AS Kredit FROM tb_akun ta INNER JOIN tb_detail_trans_keluar tdtm ON ta.`id_akun` = tdtm.`id_akun` GROUP BY ta.`id_akun` ORDER BY ta.`id_akun` ASC";
$result = mysqli_query($conn, $sql);
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
                    <div class="card-header" style="background-color: #F2F2F2 !important;">
                        <a href="./tambah-data/" class="btn btn-success btn-sm">Tambah Akun</a>
                        <a href="./tambah-kategori/" class="btn btn-secondary btn-sm">Tambah Kategori</a>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold" style="opacity: 0.2;">Neraca Saldo Pemasukan</h5>
                        <table class="table table-bordered table-striped" style="font-size: 14px !important;">
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
                                        echo "<tr>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['Debet'] . "</td>";
                                        echo "<td>" . $row['Kredit'] . "</td>";
                                        echo "</tr>";
                                        $jumDebet += $row['Debet'];
                                        $jumKredit += $row['Kredit'];
                                    }
                                ?>
                                    <tr>
                                        <td colspan="2" class="font-weight-bold">Jumlah</td>
                                        <td><?= $jumDebet ?></td>
                                        <td><?= $jumKredit ?></td>
                                    </tr>
                                <?php
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data akun.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <h5 class="font-weight-bold mt-4" style="opacity: 0.2;">Neraca Saldo Pengeluaran</h5>
                        <table class="table table-bordered table-striped" style="font-size: 14px !important;">
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
                                if ($result2->num_rows > 0) {
                                    $jumDebet = 0;
                                    $jumKredit = 0;
                                    while ($row = $result2->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['Debet'] . "</td>";
                                        echo "<td>" . $row['Kredit'] . "</td>";
                                        echo "</tr>";
                                        $jumDebet += $row['Debet'];
                                        $jumKredit += $row['Kredit'];
                                    }
                                ?>
                                    <tr>
                                        <td colspan="2" class="font-weight-bold">Jumlah</td>
                                        <td><?= $jumDebet ?></td>
                                        <td><?= $jumKredit ?></td>
                                    </tr>
                                <?php
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data akun.</td></tr>";
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