<?php
session_start();

include "../../controller/KoneksiController.php";

$name_page = "Data Transaksi";
$type_page = 2;

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

if ($id === 0) {
    $prefix = "TRX-";
    $date = date("YmdHis"); // Format tanggal dan waktu
    $counter = 1;

    do {
        $id_transaksi = $prefix . $date . sprintf("%04d", $counter); // sprintf untuk format angka 4 digit
        $sql = "SELECT id_transaksi_masuk FROM tb_transaksi_masuk WHERE id_transaksi_masuk = '$id_transaksi'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {
            $unique = true;
        } else {
            $counter++;
        }
    } while (!$unique);
} else {
    $id_transaksi = $id;
}

$sql0 = "SELECT * FROM tb_detail_trans_masuk INNER JOIN tb_akun USING (id_akun) WHERE id_transaksi_masuk = '$id'";
$result0 = mysqli_query($conn, $sql0);

$totalDebet = 0;
$totalKredit = 0;

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
                            <h1 class="m-0">Tambah Data Transaksi Pemasukan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 col-lg-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../">Data Transaksi</a></li>
                                <li class="breadcrumb-item active">Tambah Data Transaksi Pemasukan</li>
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
                                    <form id="tambahForm" action="../../controller/input-data-detail-trans-masuk.php" method="post">
                                        <input type="hidden" name="type" value="1">
                                        <input type="hidden" name="id-transaksi" id="id-transaksi" value="<?= $id_transaksi ?>">
                                        <div class="form-group row">
                                            <label for="id-akun" class="col-sm-2 col-form-label">Akun</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="id-akun" name="id-akun" required>
                                                    <option style="display: none;"></option>
                                                    <?php
                                                    $sql = "SELECT * FROM tb_akun";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                                        <option value="<?= $row['id_akun'] ?>"><?= $row['nama'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <label for="nominal" class="col-2 col-form-label">Nominal</label>
                                            <div class="form-group col-5">
                                                <input type="text" class="form-control" name="debet" placeholder="Debet" onkeyup="formatCurrency(this)">
                                            </div>
                                            <div class="form-group col-5">
                                                <input type="text" class="form-control" name="kredit" placeholder="Kredit" onkeyup="formatCurrency(this)">
                                            </div>
                                            <div class="form-group col-12">
                                                <button class="btn btn-warning btn-sm float-right" id="tambahButton">+ Tambah Detail Transaksi</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 16px !important;">
                                        <thead>
                                            <tr>
                                                <th>Kode Akun</th>
                                                <th>Nama Akun</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result0->num_rows > 0) {
                                                $no = 1;
                                                while ($row = $result0->fetch_assoc()) {
                                                    echo "<tr>";
                                                    // echo "<td>" . $no . "</td>";
                                                    echo "<td>" . $row['id_akun'] . "</td>";
                                                    echo "<td>" . $row['nama'] . "</td>";
                                                    echo "<td>" . $row['debet'] . "</td>";
                                                    echo "<td>" . $row['kredit'] . "</td>";
                                            ?>
                                                    <td style="width: 20px !important;">
                                                        <form action="../../controller/delete-data-detail-trans-masuk.php" method="post">
                                                            <input type="hidden" name="id-transaksi" id="id-transaksi" value="<?= $id_transaksi ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>">
                                                            <button class="btn btn-danger btn-sm d-flex align-items-center" style="gap: 5px;">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                            <?php

                                                    // Tambahkan ke total debet dan kredit
                                                    $totalDebet += $row['debet'];
                                                    $totalKredit += $row['kredit'];

                                                    $no++; // Tingkatkan nomor baris setiap kali iterasi
                                                }
                                            } else {
                                                echo "<tr><td colspan='9'>Tidak ada data detail transaksi.</td></tr>";
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><?= $totalDebet ?></td>
                                                <td><?= $totalKredit ?></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <form id="simpanForm" action="../../controller/input-data-transaksi-masuk.php" method="post" class="mb-2 mt-4">
                                        <div class="form-group row">
                                            <label for="id-transaksi" class="col-sm-2 col-form-label">Id Transaksi</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="id-transaksi" name="id-transaksi" value="<?= $id_transaksi ?>" readonly required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-2 col-form-label">Tanggal</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date" name="date" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id-keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="id-keterangan" name="id-keterangan" required>
                                                    <option style="display: none;"></option>
                                                    <?php
                                                    $sql = "SELECT * FROM tb_keterangan WHERE type_transaksi = 1";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['keterangan'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label for="bukti" class="col-sm-2 col-form-label">Bukti Transaksi</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control-file border p-2 rounded" id="bukti" name="bukti">
                                            </div>
                                        </div> -->
                                        <div class="w-100 d-flex justify-content-end mb-4">
                                            <a href="../../controller/discard-transaksi.php?id=<?= $id_transaksi ?>&type=1" class="btn btn-danger btn-sm mr-2">Discard Transaksi</a>
                                            <button class="btn btn-success btn-sm" id="simpanButton">+ Tambah Transaksi</button>
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

        // Mengendalikan tindakan tambah dan simpan
        document.getElementById('tambahButton').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('tambahForm').submit();
        });

        document.getElementById('simpanButton').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('simpanForm').submit();
        });
    </script>
</body>

</html>