<?php

session_start();

include "../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

include "../function/delMsg.php";

function rupiahin($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return 'Rp ' . $rupiah;
}

if (isset($_GET['fill-akun'])) {
    $fillAkun = $_GET['fill-akun'];
} else {
    $fillAkun = "All";
}

$name_page = "Data All Transaksi Akun";
$type_page = 1;

$where = "";
if ($fillAkun != "All") {
    $where = "WHERE ta.nama = '" . $fillAkun . "'";
} else {
    $where = "";
}

// Inisialisasi variabel SQL
$sql = "SELECT 
    (SELECT tj.tgl_jurnal FROM tb_jurnal tj WHERE tj.id_jurnal = tdj.id_jurnal) AS Tanggal, 
    ta.nama AS Nama_Akun, 
    tdj.id_akun AS Kode_Akun, 
    SUM(tdj.debet) AS Debet, 
    SUM(tdj.kredit) AS Kredit
FROM tb_detail_jurnal tdj 
JOIN tb_akun ta ON ta.id_akun = tdj.id_akun 
" . $where . "
GROUP BY Tanggal, Nama_Akun
ORDER BY Tanggal DESC, tdj.`created_at` ASC";

$result = mysqli_query($conn, $sql);


?>

<?php include "../assets/template/header.php" ?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php include "../assets/template/navbar.php" ?>

        <?php include "../assets/template/side-bar.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1>Data All Transaksi Akun</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item active"><a href="./">Data All Transaksi Akun</a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET" style="display: flex; align-items:flex-end;">
                            <div class="form-group col-3">
                                <label for="fillter">Fillter Akun</label>
                                <select class="form-control" id="fillter" name="fill-akun">
                                    <option style="display: none;"></option>
                                    <?php
                                    $sqlAkun = "SELECT * FROM tb_akun";
                                    $resultAkun = mysqli_query($conn, $sqlAkun);
                                    if ($resultAkun->num_rows > 0) {
                                        while ($rowAkun = $resultAkun->fetch_assoc()) {
                                    ?>
                                            <option <?= ($rowAkun['nama'] == $fillAkun) ? "selected" : "" ?>><?= $rowAkun['nama'] ?></option>
                                    <?php
                                        }
                                    } else {
                                        echo "<option>Tidak Ada Akun</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4 p-3">
                                <button class="btn btn-danger">Cari</button>
                                <a href="./" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i></a>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Akun</th>
                                    <th>Kode Akun</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px !important;">
                                <?php
                                if ($result->num_rows > 0) {
                                    $previousTanggalJurnal = null;
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <?php
                                            if ($row['Tanggal'] != $previousTanggalJurnal) {
                                            ?>
                                                <td>
                                                    <a class="badge badge-info badge-sm" href="detail-transaksi/?tgl=<?= $row['Tanggal'] ?>&fill-akun=<?= $fillAkun ?>">Detail </a> /
                                                    <?= $row['Tanggal'] ?>
                                                </td>
                                            <?php
                                            } else {
                                                echo "<td></td>";
                                            }
                                            ?>
                                            <td><?= $row['Nama_Akun'] ?></td>
                                            <td><?= $row['Kode_Akun'] ?></td>
                                            <td><?= ($row['Debet'] == 0) ? '-' : rupiahin($row['Debet']) ?></td>
                                            <td><?= ($row['Kredit'] == 0) ? '-' : rupiahin($row['Kredit']) ?></td>
                                        </tr>
                                <?php
                                        $previousTanggalJurnal = $row['Tanggal'];
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data transaksi.</td></tr>";
                                }

                                // Tutup koneksi
                                $conn->close();
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
    <script src="../assets/js/jQuery.js"></script>
    <!-- Data Table -->
    <script src="../assets/js/dataTable.min.js"></script>
    <script src="../assets/js/dataTable.bootstrap4.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <!-- <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script> -->
</body>

</html>