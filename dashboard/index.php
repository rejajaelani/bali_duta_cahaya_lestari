<?php

session_start();

include "../controller/KoneksiController.php";

if (isset($_SESSION['isLogin']) != true) {
    header("Location: ../");
    exit;
}

include "../function/delMsg.php";

$name_page = "Dashboard";
$type_page = 1;

$currentMonth = date('m');
$currentYear = date('Y');

if (isset($_GET['src-year'])) {
    $selectedYear = intval($_GET['src-year']);
} else {
    $selectedYear = intval($currentYear);
}



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
                            <h1>Beranda</h1>
                        </div>
                        <div class="col-12">
                            <ol class="breadcrumb float-left">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active"><a href="./">Beranda</a></li>
                            </ol>
                        </div>
                        <?php
                        include "../function/getData.php";

                        // print_r($_SESSION['dataUser']);
                        // print_r(getDataUser());
                        // echo "<br/><br/>";
                        // print_r(getDataUserDetail(1))
                        ?>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?php

                $sql1 = "SELECT SUM(debet) AS Debet, SUM(kredit) AS Kredit FROM tb_detail_trans_masuk WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) = " . $currentMonth;
                $sql2 = "SELECT SUM(debet) AS Debet, SUM(kredit) AS Kredit FROM tb_detail_trans_keluar WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) = " . $currentMonth;
                $result1 = mysqli_query($conn, $sql1);
                $result2 = mysqli_query($conn, $sql2);
                $row1 = mysqli_fetch_assoc($result1);
                $row2 = mysqli_fetch_assoc($result2);

                $totalPengeluaran = $row2['Debet'] + $row2['Kredit'];
                $totalPemasukan = $row1['Debet'] + $row1['Kredit'];
                ?>
                <!-- Default box -->
                <div class="card">
                    <div class="card-body d-flex justify-content-center flex-column align-items-center text-white rounded" style="background-color: #1AB394;">
                        <h3>Selamat Datang di PT. Bali Duta Cahaya Lestari</h3>
                        <p><?= $row['nama'] ?></p>
                        <img class="logo-dashboard" src="../images/logo.png" alt="Logo dasboard">
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="footer-card-header mt-2 mb-4 w-100 d-flex justify-content-end" style="gap: 10px;">
                            <a href="../data-user/edit-data/?id=<?= $_SESSION['dataUser']['id_user'] ?>" class="btn btn-secondary">Edit Profil</a>
                            <a href="../edit-password/" class="btn btn-secondary">Ubah Password</a>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="mr-2 p-3 bg-success w-100 rounded" style="text-align: right;border: 2px solid #242424;color: #242424 !important;font-size: 22px;font-weight: bold;">
                                Pengeluaran Bulan <?php echo date('F'); ?> <br>
                                <?= 'Rp. ' . number_format($totalPengeluaran, 0, ',', '.'); ?>
                            </div>
                            <div class="ml-2 p-3 bg-warning w-100 rounded" style="text-align: right;border: 2px solid #242424;color: #242424 !important;font-size: 22px;font-weight: bold;">
                                Pemasukan Bulan <?php echo date('F'); ?> <br>
                                <?= 'Rp. ' . number_format($totalPemasukan, 0, ',', '.'); ?>
                            </div>
                        </div>
                        <div class="wrapper-chart">
                            <!-- BAR CHART -->
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <form action="" method="GET">
                                                <div class="form-row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <select class="form-control" name="src-year" id="src-year">
                                                                <option <?= ($selectedYear == 2023) ? 'selected' : '' ?>>2023</option>
                                                                <option <?= ($selectedYear == 2022) ? 'selected' : '' ?>>2022</option>
                                                                <option <?= ($selectedYear == 2021) ? 'selected' : '' ?>>2021</option>
                                                                <option <?= ($selectedYear == 2020) ? 'selected' : '' ?>>2020</option>
                                                                <option <?= ($selectedYear == 2019) ? 'selected' : '' ?>>2019</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <button class="btn btn-danger">Cari</button>
                                                        <a href="./" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i></a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="chart">
                                        <canvas id="barChart" style="width: 100%;height: 400px;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.card -->

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

    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/plugins/jszip/jszip.min.js"></script>
    <script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- ChartJS -->
    <script src="../assets/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../assets/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../assets/dist/js/demo.js"></script>

    <!-- Data Debet & Kredit By Month -->
    <?php
    $dataDebet = [];
    $dataKredit = [];

    for ($i = 1; $i <= 12; $i++) {
        $sqlData1 = "SELECT SUM(debet) AS Debet, SUM(kredit) AS Kredit FROM tb_detail_trans_masuk WHERE YEAR(created_at) = $selectedYear AND MONTH(created_at) = " . $i;
        $sqlData2 = "SELECT SUM(debet) AS Debet, SUM(kredit) AS Kredit FROM tb_detail_trans_keluar WHERE YEAR(created_at) = $selectedYear AND MONTH(created_at) = " . $i;
        $resultData1 = mysqli_query($conn, $sqlData1);
        $resultData2 = mysqli_query($conn, $sqlData2);
        $rowData1 = mysqli_fetch_assoc($resultData1);
        $rowData2 = mysqli_fetch_assoc($resultData2);
        $debet1 = intval($rowData1['Debet'] ?? 0);
        $debet2 = intval($rowData2['Debet'] ?? 0);
        $kredit1 = intval($rowData1['Kredit'] ?? 0);
        $kredit2 = intval($rowData2['Kredit'] ?? 0);

        $dataDebet[] = $debet1 + $kredit1;
        $dataKredit[] = $debet2 + $kredit2;
    }

    // echo "Debet --------------------- </br>";
    // var_dump($dataDebet);
    // echo "Kredit --------------------- </br>";
    // var_dump($dataKredit);
    ?>


    <script>
        $(function() {
            var namaBulanE = [
                "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
            ];

            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            var dataDebet = <?php echo json_encode($dataDebet); ?>;
            var dataKredit = <?php echo json_encode($dataKredit); ?>;

            // console.log("Data Debet:", dataDebet);
            // console.log("Data Kredit:", dataKredit);

            // BAR CHART DATA
            var barChartData = {
                labels: namaBulanE,
                datasets: [{
                        label: 'Pemasukan Rp ',
                        backgroundColor: '#2CAEFE',
                        borderColor: '#2CAEFE',
                        borderWidth: 1,
                        data: dataDebet
                    },
                    {
                        label: 'Pengeluaran Rp ',
                        backgroundColor: '#544FC5',
                        borderColor: '#544FC5',
                        borderWidth: 1,
                        data: dataKredit
                    }
                ]
            };

            // BAR CHART OPTIONS
            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            };

            // Get the canvas element
            var barChartCanvas = document.getElementById('barChart');

            // Create the bar chart
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        });
    </script>

</body>

</html>