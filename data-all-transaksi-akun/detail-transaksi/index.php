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

$name_page = "Data All Transaksi Akun";
$type_page = 2;
$GetTgl = $_GET['tgl'];
$fillAkun = $_GET['fill-akun'];

$and = "";
if ($fillAkun != "All") {
    $and = "AND ta.nama = '" . $fillAkun . "'";
} else {
    $and = "";
}

// Inisialisasi variabel SQL
$sql = "SELECT 
tj.tgl_jurnal AS Tanggal, 
ta.nama AS Nama_Akun, 
tdj.id_akun AS Kode_Akun, 
SUM(tdj.debet) AS Debet, 
SUM(tdj.kredit) AS Kredit
FROM tb_detail_jurnal tdj 
JOIN tb_jurnal tj ON tj.id_jurnal = tdj.id_jurnal 
JOIN tb_akun ta ON ta.id_akun = tdj.id_akun 
WHERE CAST(tj.tgl_jurnal AS DATE) = '$GetTgl' " . $and . "
GROUP BY Tanggal, Nama_Akun
ORDER BY Tanggal DESC";
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
                        <div class="col-12">
                            <h1>Data Detail Transaksi Akun</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item active"><a href="../">Data All Transaksi Akun</a></li>
                                <li class="breadcrumb-item active">Data Detail Transaksi Akun</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12 d-flex justify-content-between">
                                    <p class="bg-danger" style="padding: 2px 10px;border-radius: 5px;"><?= $row['Nama_Akun'] ?></p>
                                    <p><?= $row['Kode_Akun'] ?></p>
                                </div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">
                                                <div class="d-flex justify-content-center align-items-center" style="height: 70px !important;">Tanggal</div>
                                            </th>
                                            <th rowspan="2">
                                                <div class="d-flex justify-content-center align-items-center" style="height: 70px !important;">Keterangan</div>
                                            </th>
                                            <th rowspan="2">
                                                <div class="d-flex justify-content-center align-items-center" style="height: 70px !important;">Debet</div>
                                            </th>
                                            <th rowspan="2">
                                                <div class="d-flex justify-content-center align-items-center" style="height: 70px !important;">Kredit</div>
                                            </th>
                                            <th colspan="2">Saldo</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-secondary">Debet</th>
                                            <th class="bg-secondary">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px !important;">
                                        <?php
                                        $Nama_Akun = $row['Nama_Akun'];
                                        $sql2 = "SELECT 
                                            tj.tgl_jurnal AS Tanggal, 
                                            ta.nama AS Nama_Akun, 
                                            tj.keterangan AS Keterangan, 
                                            tdj.debet AS Debet, 
                                            tdj.kredit AS Kredit, 
                                            tdj.`created_at`
                                            FROM tb_akun ta 
                                            JOIN tb_detail_jurnal tdj ON tdj.id_akun = ta.id_akun 
                                            JOIN tb_jurnal tj ON tj.id_jurnal = tdj.id_jurnal 
                                            WHERE ta.nama = '$Nama_Akun' AND DATE(tj.tgl_jurnal) <= '$GetTgl'
                                            ORDER BY tj.tgl_jurnal ASC";
                                        $result2 = mysqli_query($conn, $sql2);
                                        if ($result2->num_rows > 0) {
                                            $previousTanggalJurnal = null;
                                            $saldo = 0;
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $saldo += ($row2['Debet'] - ($row2['Kredit']));
                                        ?>
                                                <tr>
                                                    <?php
                                                    if ($row2['Tanggal'] != $previousTanggalJurnal) {
                                                    ?>
                                                        <td>
                                                            <?= $row2['Tanggal'] ?>
                                                        </td>
                                                    <?php
                                                    } else {
                                                        echo "<td></td>";
                                                    }
                                                    ?>
                                                    <td><?= $row2['Keterangan'] ?></td>
                                                    <td><?= ($row2['Debet'] == 0) ? '-' : rupiahin($row2['Debet']) ?></td>
                                                    <td><?= ($row2['Kredit'] == 0) ? '-' : rupiahin($row2['Kredit']) ?></td>
                                                    <?php
                                                    if ($saldo > 0) {
                                                    ?>
                                                        <td><?= rupiahin($saldo) ?></td>
                                                        <td>-</td>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td>-</td>
                                                        <td><?= rupiahin($saldo) ?></td>
                                                    <?php } ?>
                                                </tr>
                                        <?php
                                                $previousTanggalJurnal = $row2['Tanggal'];
                                            }
                                        } else {
                                            echo "<tr><td colspan='9'>Tidak ada data transaksi.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data transaksi.</td></tr>";
                }
                ?>
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