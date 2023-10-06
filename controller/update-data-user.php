<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./KoneksiController.php";

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Menggunakan password yang ada jika tidak ada yang baru diisi
    $existingPassword = mysqli_fetch_assoc(mysqli_query($conn, "SELECT password FROM tb_user WHERE id_user = '$id'"))['password'];
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $existingPassword;

    $targetDirectory = "../images/"; // Folder tempat menyimpan file yang diunggah

    // Mendapatkan informasi tentang file yang diunggah
    $fileName = $_FILES["foto"]["name"];
    $fileSize = $_FILES["foto"]["size"];
    $fileTmpName = $_FILES["foto"]["tmp_name"];
    $fileType = $_FILES["foto"]["type"];
    $fileError = $_FILES["foto"]["error"];

    // Menggunakan foto yang ada jika tidak ada yang baru diisi
    $existingFoto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM tb_user WHERE id_user = '$id'"))['foto'];

    if ($fileName) {
        // Memeriksa tipe-tipe file gambar yang diperbolehkan
        $allowedImageTypes = array("image/jpeg", "image/png", "image/gif");

        // Memeriksa apakah terdapat error saat mengunggah
        if ($fileError === 0 && in_array($fileType, $allowedImageTypes)) {
            // Membuat nama file acak
            $randomFileName = uniqid() . "_" . time();

            // Menghapus foto lama jika ada
            if ($existingFoto) {
                $existingFotoPath = $targetDirectory . $existingFoto;
                if (file_exists($existingFotoPath)) {
                    unlink($existingFotoPath);
                }
            }

            // Membuat path lengkap untuk menyimpan file
            $foto = $randomFileName . "." . pathinfo($fileName, PATHINFO_EXTENSION);
            $filePath = $targetDirectory . $foto;

            // Memindahkan file ke folder tujuan
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                echo "Terjadi kesalahan saat mengunggah file.";
                exit;
            }
        } else {
            echo "Tipe file tidak valid. Hanya file gambar (jpeg, png, gif) yang diperbolehkan.";
            exit;
        }
    } else {
        // Jika tidak ada foto baru diisi, gunakan foto yang ada
        $foto = $existingFoto;
    }

    $sql = "UPDATE tb_user SET nama = '$nama', email = '$email', username = '$username', password = '$password', status = '$status', foto = '$foto' WHERE id_user = '$id'";

    if ($result = mysqli_query($conn, $sql)) {
        if ($level == 1) {
            header("Location: ../data-user/pimpinan/");
            exit;
        } else if ($level == 2) {
            header("Location: ../data-user/admin/");
            exit;
        } else {
            header("Location: ../data-user/akunting/");
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
