<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');

    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $type_keterangan = mysqli_escape_string($conn, $_POST['type-keterangan']);
    $type_transaksi = mysqli_escape_string($conn, $_POST['type-transaksi']);
    $tgl_now = date('Y-m-d H:i:s');

    $sql = "INSERT INTO tb_keterangan (keterangan, type_keterangan, type_transaksi, update_at) VALUES ('$keterangan', $type_keterangan, $type_transaksi, '$tgl_now')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['msg-f'] = [
            'key' => 'Data keterangan gagal ditambahkan' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-keterangan/");
        exit;
    }

    $_SESSION['msg'] = [
        'key' => 'Data keterangan berhasil ditambahkan',
        'timestamp' => time()
    ];
    header("Location: ../data-keterangan/");
    exit;
}
