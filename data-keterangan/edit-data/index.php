<?php
session_start();

include "../../controller/KoneksiController.php";

$name_page = "Data Alat";
$type_page = 2;

$id = $_GET['id'];

// Inisialisasi variabel SQL
$sql = "SELECT * FROM tb_keterangan WHERE id = " . $id;
$result = mysqli_query($conn, $sql);

?>

<?php include "../../assets/template/header.php" ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include "../../assets/template/navbar.php" ?>

        <?php include "../../assets/template/side-bar.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6 col-lg-12">
                            <h1 class="m-0">Edit Data Alat</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 col-lg-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">Data Alat</a></li>
                                <li class="breadcrumb-item active">Edit Data Alat</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <form action="../../controller/update-data-keterangan.php" method="post">
                                                <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>" required>
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $row['keterangan'] ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="type-transaksi">Type Transaksi</label>
                                                    <select class="form-control" id="type-transaksi" name="type-transaksi">
                                                        <option <?= ($row['type_transaksi'] == 1) ? 'selected' : '' ?> value="1">Pemasukan</option>
                                                        <option <?= ($row['type_transaksi'] == 2) ? 'selected' : '' ?> value="2">Pengeluaran</option>
                                                    </select>
                                                </div>
                                                <div class="row" style="width: max-content !important;">
                                                    <div class="col">
                                                        <button class="btn btn-success">Simpan</button>
                                                    </div>
                                                    <div class="col p-0">
                                                        <a href="../" class="btn btn-danger">Kembali</a>
                                                    </div>
                                                </div>
                                            </form>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
    </div>

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
    <!-- AdminLTE App -->
    <script src="../../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script>

</body>

</html>