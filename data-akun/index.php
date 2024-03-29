<?php

session_start();

include "../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

include "../function/delMsg.php";

$name_page = "Data Akun";
$type_page = 1;

// Inisialisasi variabel SQL
$sql = "SELECT * FROM tb_akun INNER JOIN tb_kategori_akun USING (id_kategori_akun)";
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
                            <h1>Data Akun</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item active"><a href="./">Data Akun</a></li>
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
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 14px !important;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Akun</th>
                                    <th>Akun</th>
                                    <th>Kategori</th>
                                    <th>Sifat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1; // Inisialisasi nomor baris
                                    // Output data pengguna ke dalam tabel
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['id_akun'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['nama_kategori'] . "</td>";
                                        echo "<td>" . $row['sifat'] . "</td>";
                                ?>
                                        <td style="width: 135px !important;">
                                            <div class="wrapper" style="display: flex;gap: 10px;">
                                                <a href="edit-data/?id=<?= $row['id_akun'] ?>" class="btn btn-sm btn-primary d-flex align-items-center" style="gap: 5px;">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm d-flex align-items-center" style="gap: 5px;" data-toggle="modal" data-target="#exampleModal-<?= $row['id_akun'] ?>">
                                                    <i class="fas fa-times"></i> Delete
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal-<?= $row['id_akun'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-<?= $row['id_akun'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel-<?= $row['id_akun'] ?>">Delete User</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="../controller/delete-data-akun.php" method="post">
                                                                <div class="modal-body">
                                                                    <p>Apakah anda yakin ingin menghapus user ini?</p>
                                                                    <input type="hidden" name="id" id="id" value="<?= $row['id_akun'] ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                <?php
                                        $no++; // Tingkatkan nomor baris setiap kali iterasi
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data akun.</td></tr>";
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
    <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>