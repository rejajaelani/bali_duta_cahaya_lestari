<?php
session_start();

include "../../controller/KoneksiController.php";

$name_page = "Data Barang";
$type_page = 2;

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
                            <h1 class="m-0">Tambah Data Barang</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 col-lg-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">Data Barang</a></li>
                                <li class="breadcrumb-item active">Tambah Data Barang</li>
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
                                    <form action="../../controller/input-data-Barang.php" method="post">
                                        <div class="form-group">
                                            <label for="nama">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga-masuk">Harga Barang Masuk</label>
                                            <input type="text" class="form-control" id="harga-masuk" name="harga-masuk" onkeyup="formatCurrency(this)" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga-keluar">Harga Barang Keluar</label>
                                            <input type="text" class="form-control" id="harga-keluar" name="harga-keluar" onkeyup="formatCurrency(this)" required>
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

        function formatCurrency(input) {
            // Menghapus tanda koma yang ada dalam input
            var value = input.value.replace(/,/g, '');

            // Menghapus karakter selain angka
            value = value.replace(/\D/g, '');

            // Mengubah angka menjadi format ribuan
            value = new Intl.NumberFormat().format(value);

            // Menampilkan hasil di input
            input.value = value;
        }
    </script>

</body>

</html>