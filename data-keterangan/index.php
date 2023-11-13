<?php

session_start();

include "../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}


include "../function/delMsg.php";

$name_page = "Data Keterangan";
$type_page = 1;

// Inisialisasi variabel SQL
$sql = "SELECT * FROM tb_keterangan";
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
                            <h1>Data Keterangan</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Data Keterangan</li>
                                <li class="breadcrumb-item active"><a href="./">Data Keterangan</a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Tabel Data Keterangan Pemasukan start -->
                <div class="card">
                    <div class="card-header" style="background-color: #FFFF !important;">
                        <a href="./tambah-data/" class="btn btn-success">Tambah Data</a>
                        <h5 class="text-center">Data Keterangan</h5>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Keterangan</th>
                                    <th>Type Keterangan</th>
                                    <th>Type Transaksi</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['keterangan'] . "</td>";
                                        if ($row['type_keterangan'] == 1) {
                                            echo "<td>Operasional</td>";
                                        } elseif ($row['type_keterangan'] == 2) {
                                            echo "<td>Investasi</td>";
                                        } elseif ($row['type_keterangan'] == 3) {
                                            echo "<td>Pendanaan</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }
                                        if ($row['type_transaksi'] == 1) {
                                            echo "<td>Pemasukan</td>";
                                        } elseif ($row['type_transaksi'] == 2) {
                                            echo "<td>Pengeluaran</td>";
                                        } elseif ($row['type_transaksi'] == 3) {
                                            echo "<td>Jurnal</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }
                                        echo "<td>" . $row['created_at'] . "</td>";
                                        echo "<td>" . $row['update_at'] . "</td>";
                                ?>
                                        <td style="width: 135px !important;">
                                            <div class="wrapper" style="display: flex;gap: 10px;">
                                                <a href="edit-data/?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary d-flex align-items-center" style="gap: 5px;">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                                <form action="../controller/delete-data-Keterangan.php" method="post">
                                                    <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>">
                                                    <button class="btn btn-danger btn-sm d-flex align-items-center" style="gap: 5px;">
                                                        <i class="fas fa-times"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                <?php
                                        $no++; // Tingkatkan nomor baris setiap kali iterasi
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data user.</td></tr>";
                                }


                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tabel Data Keterangan Pemasukan end -->

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