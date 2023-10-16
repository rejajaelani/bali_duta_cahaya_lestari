<?php

if (isset($_SESSION['msg']) && is_array($_SESSION['msg'])) {

    if (isset($_SESSION['msg'])) {
        // Periksa apakah timestamp lebih dari 3 detik yang lalu
        $timestamp = $_SESSION['msg']['timestamp'];
        $current_time = time();

        if ($current_time - $timestamp >= 3) {
            // Hapus data dari session
            unset($_SESSION['msg']);
        }
    }
}

if (isset($_SESSION['msg-w']) && is_array($_SESSION['msg-w'])) {

    if (isset($_SESSION['msg-w'])) {
        // Periksa apakah timestamp lebih dari 3 detik yang lalu
        $timestamp = $_SESSION['msg-w']['timestamp'];
        $current_time = time();

        if ($current_time - $timestamp >= 3) {
            // Hapus data dari session
            unset($_SESSION['msg-w']);
        }
    }
}

if (isset($_SESSION['msg-f']) && is_array($_SESSION['msg-f'])) {

    if (isset($_SESSION['msg-f'])) {
        // Periksa apakah timestamp lebih dari 3 detik yang lalu
        $timestamp = $_SESSION['msg-f']['timestamp'];
        $current_time = time();

        if ($current_time - $timestamp >= 3) {
            // Hapus data dari session
            unset($_SESSION['msg-f']);
        }
    }
}
