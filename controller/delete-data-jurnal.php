<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./KoneksiController.php";

    $id_jurnal = mysqli_real_escape_string($conn, $_POST['id-jurnal']);

    $sql0 = "DELETE FROM tb_jurnal WHERE id_jurnal = '$id_jurnal'";
    $sql1 = "DELETE FROM tb_detail_jurnal WHERE id_jurnal = '$id_jurnal'";
    $result0 = mysqli_query($conn, $sql0);
    $result1 = mysqli_query($conn, $sql1);

    if (!$result0) {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-jurnal/");
        exit;
    }

    if (!$result1) {
        $_SESSION['msg-f'] = [
            'key' => 'Error : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-jurnal/");
        exit;
    }

    $_SESSION['msg'] = [
        'key' => 'Data jurnal berhasil di delete',
        'timestamp' => time()
    ];
    header("Location: ../data-jurnal/");
    exit;
}
