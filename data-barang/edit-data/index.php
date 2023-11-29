<?php
session_start();

include "../../controller/KoneksiController.php";

$name_page = "Data Barang";
$type_page = 2;

$id = mysqli_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM tb_barang WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error : " . mysqli_error($conn);
}

function formatCurrency($input)
{
    // Menghapus tanda koma yang ada dalam input
    $value = str_replace(',', '', $input);

    // Menghapus karakter selain angka
    $value = preg_replace(
        '/\D/',
        '',
        $value
    );

    // Mengubah angka menjadi format ribuan
    $value = number_format($value);

    // Mengembalikan hasil
    return $value;
}

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
                            <h1 class="m-0">Edit Data Barang</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 col-lg-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">Data Barang</a></li>
                                <li class="breadcrumb-item active">Edit Data Barang</li>
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
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <form action="../../controller/update-data-Barang.php" method="post">
                                            <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>">
                                            <div class="form-group">
                                                <label for="nama">Nama Barang</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama_barang'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga-masuk">Harga Barang Masuk</label>
                                                <?php
                                                $harga_masuk = formatCurrency($row['harga_barang_masuk']);
                                                ?>
                                                <input type="text" class="form-control" id="harga-masuk" name="harga-masuk" value="<?= $harga_masuk ?>" onkeyup="formatCurrency(this)" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga-keluar">Harga Barang Keluar</label>
                                                <?php
                                                $harga_keluar = formatCurrency($row['harga_barang_keluar']);
                                                ?>
                                                <input type="text" class="form-control" id="harga-keluar" name="harga-keluar" value="<?= $harga_keluar ?>" onkeyup="formatCurrency(this)" required>
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
                                    <?php } ?>
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
    <script src="../assets/js/jQuery.js"></script>
    <!-- Data Table -->
    <script src="../assets/js/dataTable.min.js"></script>
    <script src="../assets/js/dataTable.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../assets/dist/js/demo.js"></script>
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