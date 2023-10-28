<?php

session_start();

include "./KoneksiController.php";

$id_transaksi = mysqli_real_escape_string($conn, $_GET['id']);
$type = mysqli_real_escape_string($conn, $_GET['type']);

if ($type == 1) {
    $sql = "DELETE FROM tb_detail_trans_masuk WHERE id_transaksi_masuk = '$id_transaksi'";
} else {
    $sql = "DELETE FROM tb_detail_trans_keluar WHERE id_transaksi_keluar = '$id_transaksi'";
}
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-transaksi/");
    exit;
}
header("Location: ../data-transaksi/");
exit;
