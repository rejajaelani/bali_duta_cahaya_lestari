<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_transaksi = mysqli_escape_string($conn, $_POST['id-transaksi']);
    $id_akun = mysqli_escape_string($conn, $_POST['id-akun']);
    $debet = mysqli_escape_string($conn, $_POST['debet']);
    $kredit = mysqli_escape_string($conn, $_POST['kredit']);
    $type = mysqli_escape_string($conn, $_POST['type']);

    $sql = "INSERT INTO tb_detail_trans_masuk (id_transaksi_masuk, id_akun, debet, kredit, update_at) VALUES('$id_transaksi', '$id_akun', $debet, $kredit, '$tgl_now')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $_SESSION['msg-f'] = [
            'key' => 'Data detail transaksi masuk gagal ditambahkan' . mysqli_error($conn),
            'timestamp' => time()
        ];
        if ($type == 1) {
            header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
            exit;
        } else {
            header("Location: ../data-transaksi/edit-data-pemasukan/?id=$id_transaksi");
            exit;
        }
    }

    $_SESSION['msg'] = [
        'key' => 'Data detail transaksi masuk berhasil ditambahkan',
        'timestamp' => time()
    ];
    if ($type == 1) {
        header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
        exit;
    } else {
        header("Location: ../data-transaksi/edit-data-pemasukan/?id=$id_transaksi");
        exit;
    }
}
