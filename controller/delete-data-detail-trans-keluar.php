<?php

session_start();

include "./KoneksiController.php";

$id_transaksi = mysqli_real_escape_string($conn, $_POST['id-transaksi']);
$id = mysqli_real_escape_string($conn, $_POST['id']);
$type = mysqli_escape_string($conn, $_POST['type']);

$sql = "DELETE FROM tb_detail_trans_keluar WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    if ($type == 1) {
        header("Location: ../data-transaksi/tambah-data-pengeluaran/?id=$id_transaksi");
        exit;
    } else {
        header("Location: ../data-transaksi/edit-data-pengeluaran/?id=$id_transaksi");
        exit;
    }
}

if ($result) {
    $sqlJurnal = "DELETE FROM tb_detail_jurnal WHERE id = '$id'";
    $resultJurnal = mysqli_query($conn, $sqlJurnal);
    if (!$resultJurnal) {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        if ($type == 1) {
            header("Location: ../data-transaksi/tambah-data-pengeluaran/?id=$id_transaksi");
            exit;
        } else {
            header("Location: ../data-transaksi/edit-data-pengeluaran/?id=$id_transaksi");
            exit;
        };
    }
    $_SESSION['msg'] = [
        'key' => 'Detail transaksi berhasil di delete',
        'timestamp' => time()
    ];
    if ($type == 1) {
        header("Location: ../data-transaksi/tambah-data-pengeluaran/?id=$id_transaksi");
        exit;
    } else {
        header("Location: ../data-transaksi/edit-data-pengeluaran/?id=$id_transaksi");
        exit;
    }
}
