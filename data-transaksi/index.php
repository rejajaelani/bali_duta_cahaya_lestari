<?php

session_start();

include "../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}


include "../function/delMsg.php";

$name_page = "Data Transaksi";
$type_page = 1;

// Inisialisasi variabel SQL
$sql1 = "SELECT * FROM tb_transaksi_masuk ttm INNER JOIN tb_keterangan tbk ON ttm.id_keterangan = tbk.id INNER JOIN tb_detail_trans_masuk tdtm ON ttm.id_transaksi_masuk = tdtm.id_transaksi_masuk INNER JOIN tb_akun ta ON tdtm.id_akun = ta.id_akun ORDER BY tdtm.id DESC";
$sql2 = "SELECT * FROM tb_transaksi_keluar ttk INNER JOIN tb_keterangan tbk ON ttk.id_keterangan = tbk.id INNER JOIN tb_detail_trans_keluar tdtk ON ttk.id_transaksi_keluar = tdtk.id_transaksi_keluar INNER JOIN tb_akun ta ON tdtk.id_akun = ta.id_akun ORDER BY tdtk.id DESC";
$result_pemasukan = mysqli_query($conn, $sql1);
$result_pengeluaran = mysqli_query($conn, $sql2);

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
                            <h1>Data Transaksi</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Data Transaksi</li>
                                <li class="breadcrumb-item active"><a href="./">Data Transaksi</a></li>
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
                        <a href="./tambah-data-pemasukan/" class="btn btn-success">Tambah Data</a>
                        <h5 class="text-center">Data Transaksi Pemasukan</h5>
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
                                if ($result_pemasukan->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result_pemasukan->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['tgl_trans_masuk'] . "</td>";
                                        echo "<td>" . $row['keterangan'] . "</td>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['debet'] . "</td>";
                                        echo "<td>" . $row['kredit'] . "</td>";
                                ?>
                                        <td style="width: 135px !important;">
                                            <div class="wrapper" style="display: flex;gap: 10px;">
                                                <a href="edit-data-pemasukan/?id=<?= $row['id_transaksi_masuk'] ?>" class="btn btn-sm btn-primary d-flex align-items-center" style="gap: 5px;">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                                <form action="../controller/delete-data-transaksi.php" method="post">
                                                    <input type="hidden" name="id-transaksi" id="id-transaksi" value="<?= $row['id_transaksi_masuk'] ?>">
                                                    <input type="hidden" name="type" id="type" value="1">
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
                <!-- Tabel Data Transaksi Pemasukan end -->

                <!-- Tabel Data Transaksi Pengeluaran start -->
                <div class="card">
                    <div class="card-header" style="background-color: #FFFF !important;">
                        <a href="./tambah-data-pengeluaran/" class="btn btn-success">Tambah Data</a>
                        <h5 class="text-center">Data Transaksi Pengeluaran</h5>
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
                                if ($result_pengeluaran->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result_pengeluaran->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['tgl_trans_keluar'] . "</td>";
                                        echo "<td>" . $row['keterangan'] . "</td>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['debet'] . "</td>";
                                        echo "<td>" . $row['kredit'] . "</td>";
                                ?>
                                        <td style="width: 135px !important;">
                                            <div class="wrapper" style="display: flex;gap: 10px;">
                                                <a href="edit-data-pengeluaran/?id=<?= $row['id_transaksi_keluar'] ?>" class="btn btn-sm btn-primary d-flex align-items-center" style="gap: 5px;">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                                <form action="../controller/delete-data-transaksi.php" method="post">
                                                    <input type="hidden" name="id-transaksi" id="id-transaksi" value="<?= $row['id_transaksi_keluar'] ?>">
                                                    <input type="hidden" name="type" id="type" value="2">
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
                <!-- Tabel Data Transaksi Pengeluaran end -->
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