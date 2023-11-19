<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_transaksi = mysqli_escape_string($conn, $_POST['id-transaksi']);
    $tgl = mysqli_escape_string($conn, $_POST['date']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $type_transaksi = mysqli_escape_string($conn, $_POST['type-transaksi']);

    $sql = "INSERT INTO tb_transaksi_masuk (id_transaksi_masuk, keterangan, type_transaksi, tgl_trans_masuk, update_at) VALUES ('$id_transaksi', '$keterangan', $type_transaksi, '$tgl', '$tgl_now')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $sqldel = "DELETE FROM tb_detail_trans_masuk WHERE id_transaksi_masuk = '$id_transaksi'";
        $resultdel = mysqli_query($conn, $sqldel);

        if (!$resultdel) {
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
            exit;
        }

        $_SESSION['msg-f'] = [
            'key' => 'Data transaksi masuk gagal ditambahkan' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }

    if ($result) {
        $sqlJurnal = "INSERT INTO tb_jurnal (id_jurnal, keterangan, type_transaksi, tgl_jurnal, update_at) VALUE ('$id_transaksi', '$keterangan', $type_transaksi, '$tgl', '$tgl_now')";
        $resultJurnal = mysqli_query($conn, $sqlJurnal);
        if (!$resultJurnal) {
            $sqlDelJurnal = "DELETE FROM tb_detail_jurnal WHERE id_jurnal = '$id_transaksi'";
            $resultDelJurnal = mysqli_query($conn, $sqlDelJurnal);

            if (!$resultDelJurnal) {
                $_SESSION['msg-f'] = [
                    'key' => 'Error : ' . mysqli_error($conn),
                    'timestamp' => time()
                ];
                header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
                exit;
            }

            $_SESSION['msg-f'] = [
                'key' => 'Data transaksi masuk gagal ditambahkan' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-transaksi/");
            exit;
        }
        $_SESSION['msg'] = [
            'key' => 'Data transaksi masuk berhasil ditambahkan',
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }
}
