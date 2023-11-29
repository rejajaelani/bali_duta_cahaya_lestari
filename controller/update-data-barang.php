<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id = mysqli_escape_string($conn, $_POST['id']);
    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $harga_masuk = isset($_POST['harga-masuk']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['harga-masuk']))) : 0;
    $harga_keluar = isset($_POST['harga-keluar']) ? mysqli_escape_string($conn, intval(str_replace(['.', ','], '', $_POST['harga-keluar']))) : 0;

    $sql = "UPDATE tb_barang SET nama_barang = '$nama', harga_barang_masuk = $harga_masuk, harga_barang_keluar = $harga_keluar, update_at = '$tgl_now' WHERE id = $id";
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
        'key' => 'Data Barang berhasil diedit',
        'timestamp' => time()
    ];
    header("Location: ../data-barang/");
    exit;
}
