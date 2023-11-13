<?php

session_start();

include "../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}


include "../function/delMsg.php";

$name_page = "Data Jurnal";
$type_page = 1;

// Inisialisasi variabel SQL
$sql = "SELECT * FROM tb_jurnal tbj INNER JOIN tb_keterangan tbk ON tbj.id_keterangan = tbk.id LEFT JOIN tb_detail_jurnal USING (id_jurnal) LEFT JOIN tb_akun USING (id_akun) ORDER BY tbj.id_jurnal";
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
                            <h1>Data Jurnal</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Data Jurnal</li>
                                <li class="breadcrumb-item active"><a href="./">Data Jurnal</a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Tabel Data Transaksi Pemasukan start -->
                <div class="card">
                    <div class="card-header" style="background-color: #FFFF !important;">
                        <a href="./tambah-data/" class="btn btn-success">Tambah Data</a>
                        <h5 class="text-center">Data Transaksi Jurnal</h5>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 0;
                                    $previousTanggalJurnal = null; // Inisialisasi variabel untuk melacak tanggal_jurnal sebelumnya

                                    while ($row = $result->fetch_assoc()) {
                                        $no++;
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";

                                        if ($row['tgl_jurnal'] != $previousTanggalJurnal) {
                                            // Hanya tampilkan tanggal dan keterangan jika id_transaksi berbeda
                                            echo "<td>" . $row['tgl_jurnal'] . "</td>";
                                        } else {
                                            // Kosongkan kolom Tanggal dan Keterangan jika id_transaksi sama
                                            echo "<td></td>";
                                        }
                                        echo "<td>" . $row['keterangan'] . "</td>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['debet'] . "</td>";
                                        echo "<td>" . $row['kredit'] . "</td";
                                        echo "<td></td>";
                                        echo "<td>" ?>
                                        <div class="wrapper" style="display: flex;gap: 10px; width: 90px;">
                                            <a href="edit-data/?id=<?= $row['id_jurnal'] ?>" class="btn btn-sm btn-primary d-flex align-items-center" style="gap: 5px;">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form action="../controller/delete-data-jurnal.php" method="post">
                                                <input type="hidden" name="id-jurnal" id="id-jurnal" value="<?= $row['id_jurnal'] ?>">
                                                <input type="hidden" name="type" id="type" value="2">
                                                <button class="btn btn-danger btn-sm d-flex align-items-center" style="gap: 5px;">
                                                    <i class="fas fa-times"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                <?php "</td>";

                                        echo "</tr>";


                                        $previousTanggalJurnal = $row['tgl_jurnal']; // Simpan tanggal_jurnal sebelumnya
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data jurnal.</td></tr>";
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tabel Data Transaksi Pemasukan end -->

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
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script>

</body>

</html>