<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $harga_masuk = isset($_POST['harga-masuk']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['harga-masuk']))) : 0;
    $harga_keluar = isset($_POST['harga-keluar']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['harga-keluar']))) : 0;

    $sql = "INSERT INTO tb_barang (nama_barang, harga_barang_masuk, harga_barang_keluar, update_at) VALUES ('$nama', $harga_masuk, $harga_keluar, '$tgl_now')";
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
