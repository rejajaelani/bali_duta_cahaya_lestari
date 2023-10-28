<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_jurnal = mysqli_escape_string($conn, $_POST['id-jurnal']);
    $tgl = mysqli_escape_string($conn, $_POST['date']);
    $id_keterangan = intval(mysqli_escape_string($conn, $_POST['id-keterangan']));

    $sql = "INSERT INTO tb_jurnal (id_jurnal, id_keterangan, tgl_jurnal, update_at) VALUES ('$id_jurnal', $id_keterangan, '$tgl', '$tgl_now')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $sqldel = "DELETE FROM tb_detail_jurnal WHERE id_jurnal = '$id_jurnal'";
        $resultdel = mysqli_query($conn, $sqldel);

        if (!$resultdel) {
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-jurnal/tambah-data?id=$id_jurnal");
            exit;
        }

        $_SESSION['msg-f'] = [
            'key' => 'Data jurnal masuk gagal ditambahkan' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-jurnal/");
        exit;
    }

    $_SESSION['msg'] = [
        'key' => 'Data jurnal masuk berhasil ditambahkan',
        'timestamp' => time()
    ];
    header("Location: ../data-jurnal/");
    exit;
}
