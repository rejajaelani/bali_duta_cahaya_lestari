<?php

session_start();

include "./KoneksiController.php";

$id_jurnal = mysqli_real_escape_string($conn, $_POST['id-jurnal']);
$id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "DELETE FROM tb_detail_jurnal WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-jurnal/tambah-data/?id=$id_jurnal");
    exit;
}

$_SESSION['msg'] = [
    'key' => 'Detail jurnal berhasil di delete',
    'timestamp' => time()
];
header("Location: ../data-jurnal/tambah-data/?id=$id_jurnal");
exit;
