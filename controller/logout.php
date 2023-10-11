<?php

// Mulai sesi
session_start();

// Fungsi logout
function logout()
{
    // Hancurkan sesi
    session_destroy();

    // Redirect ke halaman login atau halaman lain
    header("Location: ../"); // Ganti "login.php" dengan halaman tujuan yang sesuai
    exit;
}

// Panggil fungsi logout jika ada parameter 'logout' dalam URL
if (isset($_POST['logout']) == 'logout') {
    logout();
}
