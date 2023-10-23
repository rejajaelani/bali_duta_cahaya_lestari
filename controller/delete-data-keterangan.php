<?php

session_start();

include "./KoneksiController.php";

$id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "DELETE FROM tb_keterangan WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-keterangan/");
    exit;
}

$_SESSION['msg'] = [
    'key' => 'Keterangan berhasil di delete',
    'timestamp' => time()
];
header("Location: ../data-keterangan/");
exit;
