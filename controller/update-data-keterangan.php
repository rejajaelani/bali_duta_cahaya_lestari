<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');

    $id = mysqli_escape_string($conn, $_POST['id']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $type_keterangan = mysqli_escape_string($conn, $_POST['type-keterangan']);
    $type_transaksi = mysqli_escape_string($conn, $_POST['type-transaksi']);
    $tgl_now = date('Y-m-d H:i:s');

    $sql = "UPDATE tb_keterangan SET keterangan = '$keterangan', type_keterangan = $type_keterangan, type_transaksi = $type_transaksi, update_at = '$tgl_now' WHERE id = " . $id;
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['msg-f'] = [
            'key' => 'Data keterangan gagal diupdate' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-keterangan/");
        exit;
    }

    $_SESSION['msg'] = [
        'key' => 'Data keterangan berhasil diupdate',
        'timestamp' => time()
    ];
    header("Location: ../data-keterangan/");
    exit;
}
