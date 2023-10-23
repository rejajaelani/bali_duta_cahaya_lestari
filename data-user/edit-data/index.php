<?php
session_start();

include "../../controller/KoneksiController.php";

$name_page = "Data User";
$type_page = 2;

$id = mysqli_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM tb_user WHERE id_user =" . $id;
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error : " . mysqli_error($conn);
}

while ($row = mysqli_fetch_assoc($result)) {

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
                                <h1 class="m-0">Edit Data User</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6 col-lg-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Data Master</li>
                                    <li class="breadcrumb-item"><a href="../">Data User</a></li>
                                    <li class="breadcrumb-item active">Edit Data User</li>
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
                                        <form action="../../controller/update-data-user.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="level" id="level" value="2">
                                            <input type="hidden" name="id" id="id" value="<?= $id ?>">
                                            <div class="form-group">
                                                <label for="nama">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap..." value="<?= $row['nama'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?= $row['username'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email..." value="<?= $row['email'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="level">Level</label>
                                                <select class="form-control" id="level" name="level" required>
                                                    <option style="display: none;"></option>
                                                    <?php if ($_SESSION['dataUser']['level'] == 2) { ?>
                                                        <option value="1">Admin</option>
                                                    <?php } ?>
                                                    <option value="2">Pimpinan</option>
                                                    <option value="3">Akunting</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option style="display: none;"></option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Non-Active</option>
                                                </select>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
                                            </div> -->
                                            <div class="form-group">
                                                <label for="foto">Foto</label>
                                                <input type="file" class="form-control-file" id="foto" name="foto">
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
    <?php } ?>

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
    </script>

    </body>

    </html>