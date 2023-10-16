<?php

session_start();

include "./KoneksiController.php";

$id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "DELETE FROM tb_akun WHERE id_akun = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-akun/");
    exit;
}

$_SESSION['msg'] = [
    'key' => 'Akun berhasil di delete',
    'timestamp' => time()
];
header("Location: ../data-akun/");
exit;
