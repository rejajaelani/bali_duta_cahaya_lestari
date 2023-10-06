<?php

include "./KoneksiController.php";

$id = mysqli_real_escape_string($conn, $_POST['id']);
$level = mysqli_real_escape_string($conn, $_POST['level']);

$sql = "DELETE FROM tb_user WHERE id_user =" . $id;
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error : " . mysqli_error($conn);
}

if ($level == 1) {
    header("Location: ../data-user/pimpinan/");
    exit;
} elseif ($level == 2) {
    header("Location: ../data-user/admin/");
    exit;
} else {
    header("Location: ../data-user/akunting/");
    exit;
}
