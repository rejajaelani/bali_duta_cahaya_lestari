<?php

session_start();

include "./KoneksiController.php";

$id_jurnal = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "DELETE FROM tb_detail_jurnal WHERE id_jurnal = '$id_jurnal'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Error : ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../data-jurnal/");
    exit;
}
header("Location: ../data-jurnal/");
exit;
