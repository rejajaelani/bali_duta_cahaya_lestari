<?php

session_start();

include "./KoneksiController.php";

$id_transaksi = mysqli_real_escape_string($conn, $_POST['id-transaksi']);
$id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "DELETE FROM tb_detail_trans_masuk WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
    exit;
}

$_SESSION['msg'] = [
    'key' => 'Detail transaksi berhasil di delete',
    'timestamp' => time()
];
header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
exit;
