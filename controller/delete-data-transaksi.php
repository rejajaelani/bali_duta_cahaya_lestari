<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./KoneksiController.php";

    $id_transaksi = mysqli_real_escape_string($conn, $_POST['id-transaksi']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if ($type == 1) {
        $sql0 = "DELETE FROM tb_transaksi_masuk WHERE id_transaksi_masuk = '$id_transaksi'";
        $sql1 = "DELETE FROM tb_detail_trans_masuk WHERE id_transaksi_masuk = '$id_transaksi'";
    } else {
        $sql0 = "DELETE FROM tb_transaksi_keluar WHERE id_transaksi_keluar = '$id_transaksi'";
        $sql1 = "DELETE FROM tb_detail_trans_keluar WHERE id_transaksi_keluar = '$id_transaksi'";
    }
    $result0 = mysqli_query($conn, $sql0);
    $result1 = mysqli_query($conn, $sql1);

    if (!$result0) {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }

    if (!$result1) {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }

    $_SESSION['msg'] = [
        'key' => 'Data transaksi berhasil di delete',
        'timestamp' => time()
    ];
    header("Location: ../data-transaksi/");
    exit;
}
