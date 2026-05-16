<?php
session_start();

// Cek apakah index ada
if (isset($_GET['index'])) {

    $index = $_GET['index'];

    // Hapus item dari keranjang
    unset($_SESSION['keranjang'][$index]);

    // Rapikan index array
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
}

// Kembali ke halaman kasir
header("Location: kasir.php");
exit;
?>