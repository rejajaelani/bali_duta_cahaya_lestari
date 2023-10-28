<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_jurnal = mysqli_escape_string($conn, $_POST['id-jurnal']);
    $id_akun = mysqli_escape_string($conn, $_POST['id-akun']);
    $debet = mysqli_escape_string($conn, $_POST['debet']);
    $kredit = mysqli_escape_string($conn, $_POST['kredit']);
    $type = mysqli_escape_string($conn, $_POST['type']);

    $sql = "INSERT INTO tb_detail_jurnal (id_jurnal, id_akun, debet, kredit, update_at) VALUES('$id_jurnal', '$id_akun', $debet, $kredit, '$tgl_now')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $_SESSION['msg-f'] = [
            'key' => 'Data detail jurnal gagal ditambahkan' . mysqli_error($conn),
            'timestamp' => time()
        ];
        if ($type == 1) {
            header("Location: ../data-jurnal/tambah-data/?id=$id_jurnal");
            exit;
        } else {
            header("Location: ../data-jurnal/edit-data/?id=$id_jurnal");
            exit;
        }
    }

    $_SESSION['msg'] = [
        'key' => 'Data detail jurnal berhasil ditambahkan',
        'timestamp' => time()
    ];
    if ($type == 1) {
        header("Location: ../data-jurnal/tambah-data/?id=$id_jurnal");
        exit;
    } else {
        header("Location: ../data-jurnal/edit-data/?id=$id_jurnal");
        exit;
    }
}
