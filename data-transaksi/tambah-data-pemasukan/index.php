<?php
session_start();

include "../../controller/KoneksiController.php";

$name_page = "Data Transaksi";
$type_page = 2;

include "../../function/delMsg.php";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

if ($id === 0) {
    $prefix = "TRX-";
    $date = date("Ymd"); // Format tanggal dan waktu
    $counter = 1;
    $unique = false;
    do {
        $id_transaksi = $prefix . "IN" . $date . sprintf("%04d", $counter); // sprintf untuk format angka 4 digit
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

$sql0 = "SELECT * FROM tb_detail_trans_masuk tdtm INNER JOIN tb_akun ta ON tdtm.`id_akun` = ta.`id_akun` WHERE tdtm.`id_transaksi_masuk` = '$id' ORDER BY tdtm.`created_at` DESC";
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
                                                <input type="date" class="form-control" id="date" name="date" onchange="setTanggalCache()" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="keterangan" name="keterangan" onkeyup="setKeteranganCache()" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="type-transaksi" class="col-sm-2 col-form-label">Kategori</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="type-transaksi" name="type-transaksi" onchange="setTypeTransaksiCache()" required>
                                                    <option value="4">Lainnya</option>
                                                    <option value="1">Operasional</option>
                                                    <option value="2">Investasi</option>
                                                    <option value="3">Pendanaan</option>
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
                                            <a id="btn-discard" href="../../controller/discard-transaksi.php?id=<?= $id_transaksi ?>&type=1" class="btn btn-danger btn-sm mr-2 d-none">Discard Transaksi</a>
                                            <button class="btn btn-success btn-sm d-none" id="simpanButton">+ Tambah Transaksi</button>
                                        </div>
                                    </form>
                                    <form id="tambahForm" action="../../controller/input-data-detail-trans-masuk.php" method="post">
                                        <div class="form-group row">
                                            <label for="typeTransaksi" class="col-2 col-form-label">Type Transaksi</label>
                                            <div class="col">
                                                <select class="form-control" id="typeTransaksi" required>
                                                    <option value="barang">Barang</option>
                                                    <option value="non">Non - Barang</option>
                                                </select>
                                            </div>
                                        </div>
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
                                        <div id="wrraperBarang">
                                            <div class="form-row mb-2">
                                                <label for="barang" class="col-2 col-form-label">Barang</label>
                                                <div class="form-group col-2">
                                                    <select class="form-control" id="barang" required>
                                                        <option style="display: none;"></option>
                                                        <?php
                                                        $sql = "SELECT * FROM tb_barang";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                                            <option value="<?= $row['harga_barang_masuk'] ?>"><?= $row['nama_barang'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-3">
                                                    <input id="harga" type="text" class="form-control" placeholder="harga..." readonly>
                                                </div>
                                                <div class="form-group col-2">
                                                    <input id="qyt" type="number" class="form-control" placeholder="Qyt...">
                                                </div>
                                                <div class="form-group col-3">
                                                    <input id="totalHarga" type="text" class="form-control" placeholder="Total Harga..." readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="typeDetails" class="col-2 col-form-label" style="opacity: 0;">Type Detail Transaksi</label>
                                                <div class="col">
                                                    <select class="form-control" id="typeDetails" disabled required>
                                                        <option value="">--- Pilih Debet or Kredit ---</option>
                                                        <option value="debet">Debet</option>
                                                        <option value="kredit">Kredit</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <label id="labelNominal" for="nominal" class="col-2 col-form-label d-none">Nominal</label>
                                            <div id="wrraperDebet" class="form-group col-5 d-none">
                                                <input id="debet" type="text" class="form-control" name="debet" placeholder="Debet" onkeyup="formatCurrency(this)">
                                            </div>
                                            <div id="wrraperKredit" class="form-group col-5 d-none">
                                                <input id="kredit" type="text" class="form-control" name="kredit" placeholder="Kredit" onkeyup="formatCurrency(this)">
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
                                                            <input type="hidden" name="type" id="type" value="1">
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

                                    <button id="klik2" type="button" class="btn btn-success btn-sm float-right mt-3">+ Tambah Transaksi</button>
                                    <button id="klik1" type="button" class="btn btn-danger btn-sm mr-2 float-right mt-3">Discard Transaksi</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cachedDate = localStorage.getItem('cacheTanggal');
            let cachedKeterangan = localStorage.getItem('cacheKeterangan');
            let cachedTypeTransaksi = localStorage.getItem('cacheTypeTransaksi');
            if (cachedDate) {
                document.getElementById('date').value = cachedDate;
            }
            if (cachedKeterangan) {
                document.getElementById('keterangan').value = cachedKeterangan;
            }
            if (cachedTypeTransaksi) {
                document.getElementById('type-transaksi').value = cachedTypeTransaksi;
            }

            $("#typeTransaksi").change(function() {
                if ($(this).val() == "non") {
                    $("#wrraperBarang").addClass("d-none");
                    $("#labelNominal").removeClass("d-none");
                    $("#wrraperDebet").removeClass("d-none");
                    $("#wrraperKredit").removeClass("d-none");
                } else {
                    $("#wrraperBarang").removeClass("d-none");
                    $("#labelNominal").addClass("d-none");
                    $("#wrraperDebet").addClass("d-none");
                    $("#wrraperKredit").addClass("d-none");
                }
            });

            $("#barang").change(function() {
                // Mendapatkan nilai harga_barang dari opsi yang dipilih
                var hargaBarang = $(this).val();

                var value = hargaBarang.replace(/,/g, '');

                // Menghapus karakter selain angka
                value = value.replace(/\D/g, '');

                // Mengubah angka menjadi format ribuan
                value = new Intl.NumberFormat().format(value);

                $("#harga").val("Rp. " + value);
            });

            $("#qyt").keyup(function() {
                var hargaString = $("#harga").val();
                // Membersihkan tanda mata uang dan tanda pemisah ribuan
                var hargaCleaned = hargaString.replace(/[^\d]/g, '');
                // Mengonversi menjadi tipe data integer
                var harga = parseInt(hargaCleaned);
                var qyt = $(this).val();
                var totalHarga = harga * qyt;

                // Mengubah angka menjadi format ribuan
                value = new Intl.NumberFormat().format(totalHarga);

                $("#totalHarga").val("Rp. " + value);

                $("#typeDetails").removeAttr("disabled");
            });

            $("#typeDetails").change(function() {
                var type = $(this).val();
                var hargaString = $("#totalHarga").val();
                // Membersihkan tanda mata uang dan tanda pemisah ribuan
                var hargaCleaned = hargaString.replace(/[^\d]/g, '');
                // Mengonversi menjadi tipe data integer
                var harga = parseInt(hargaCleaned);
                value = new Intl.NumberFormat().format(harga);
                if (type == "debet") {
                    $("#debet").val(value);
                    $("#kredit").val(0);
                } else if (type == "kredit") {
                    $("#kredit").val(value);
                    $("#debet").val(0);
                }

            });

        });

        function setTanggalCache() {
            let tgl = document.getElementById("date").value;
            localStorage.setItem('cacheTanggal', tgl);
        }

        function setKeteranganCache() {
            let ket = document.getElementById("keterangan").value;
            localStorage.setItem('cacheKeterangan', ket);
        }

        function setTypeTransaksiCache() {
            let type = document.getElementById("type-transaksi").value;
            localStorage.setItem('cacheTypeTransaksi', type);
        }

        const btnKlik1 = document.getElementById("klik1");
        const btnKlik2 = document.getElementById("klik2");
        const btnDiscard = document.getElementById("btn-discard");
        const btnSimpan = document.getElementById("simpanButton");
        btnKlik1.addEventListener("click", function() {
            localStorage.clear();
            btnDiscard.click();
        });
        btnKlik2.addEventListener("click", function() {
            localStorage.clear();
            btnSimpan.click();
        });
    </script>

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
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <script>
        $(document).ready(function() {
            // $("#example1").DataTable();

            var today = new Date();

            // Format tanggal ke format YYYY-MM-DD yang sesuai dengan input date
            var formattedDate = today.toISOString().split('T')[0];

            // Set nilai input date
            $("#date").val(formattedDate);

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