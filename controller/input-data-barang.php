<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $harga = isset($_POST['harga']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['harga']))) : 0;

    $sql = "INSERT INTO tb_barang (nama_barang, harga_barang, update_at) VALUES ('$nama', $harga, '$tgl_now')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-barang/");
        exit;
    }

    $_SESSION['msg'] = [
        'key' => 'Barang berhasil ditambahkan',
        'timestamp' => time()
    ];
    header("Location: ../data-barang/");
    exit;
}
