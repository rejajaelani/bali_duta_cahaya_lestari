<?php
$sqlUser = "SELECT * FROM tb_user WHERE id_user = " . $_SESSION['dataUser']["id_user"];
$resultUser = mysqli_query($conn, $sqlUser);
$row = mysqli_fetch_assoc($resultUser);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bali Duta Cahaya Lestari | <?= $name_page ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= ($type_page == 1) ? '../' : '../../' ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= ($type_page == 1) ? '../' : '../../' ?>assets/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= ($type_page == 1) ? '../' : '../../' ?>css/style.css">
    <link rel="stylesheet" href="<?= ($type_page == 1) ? '../' : '../../' ?>assets/css/dataTables.bootstrap4.min.css">

</head>