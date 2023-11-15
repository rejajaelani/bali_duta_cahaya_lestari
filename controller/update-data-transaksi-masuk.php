<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "./KoneksiController.php";
    date_default_timezone_set('Asia/Makassar');
    $tgl_now = date('Y-m-d H:i:s');

    $id_transaksi = mysqli_escape_string($conn, $_POST['id-transaksi']);
    $tgl = mysqli_escape_string($conn, $_POST['date']);
    $id_keterangan = intval(mysqli_escape_string($conn, $_POST['id-keterangan']));

    $sql = "UPDATE tb_transaksi_masuk SET tgl_trans_masuk = '$tgl', id_keterangan = $id_keterangan, update_at = '$tgl_now' WHERE id_transaksi_masuk = '$id_transaksi'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $sqldel = "DELETE FROM tb_detail_trans_masuk WHERE id_transaksi_masuk = '$id_transaksi'";
        $resultdel = mysqli_query($conn, $sqldel);

        if (!$resultdel) {
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
            exit;
        }

        $_SESSION['msg-f'] = [
            'key' => 'Data transaksi masuk gagal diupdate' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }
    if ($result) {
        $sqlJurnal = "UPDATE tb_jurnal SET tgl_jurnal = '$tgl', id_keterangan = $id_keterangan, update_at = '$tgl_now' WHERE id_jurnal = '$id_transaksi'";
        $resultJurnal = mysqli_query($conn, $sqlJurnal);
        if (!$resultJurnal) {
            $sqlDelJurnal = "DELETE FROM tb_jurnal WHERE id_jurnal = '$id_transaksi'";
            $resultDelJurnal = mysqli_query($conn, $sqlDelJurnal);
            if (!$resultDelJurnal) {
                $_SESSION['msg-f'] = [
                    'key' => 'Error : ' . mysqli_error($conn),
                    'timestamp' => time()
                ];
                header("Location: ../data-transaksi/tambah-data-pemasukan/?id=$id_transaksi");
                exit;
            }

            $_SESSION['msg-f'] = [
                'key' => 'Data transaksi masuk gagal diupdate' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../data-transaksi/");
            exit;
        }
        $_SESSION['msg'] = [
            'key' => 'Data transaksi masuk berhasil diupdate',
            'timestamp' => time()
        ];
        header("Location: ../data-transaksi/");
        exit;
    }
}
