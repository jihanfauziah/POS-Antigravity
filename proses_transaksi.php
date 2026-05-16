<?php
session_start();
include 'koneksi.php';

// Cek apakah keranjang kosong
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header("Location: kasir.php");
    exit;
}

$total = $_POST['total'];
$bayar = $_POST['bayar'];

// Validasi pembayaran
if ($bayar < $total) {
    echo "
    <script>
        alert('Uang bayar kurang!');
        window.location='kasir.php';
    </script>
    ";
    exit;
}

// Simpan transaksi
mysqli_query($conn, "INSERT INTO transaksi (total) VALUES ('$total')");

// Ambil ID transaksi terakhir
$transaksi_id = mysqli_insert_id($conn);

// Simpan detail transaksi + kurangi stok
foreach ($_SESSION['keranjang'] as $item) {

    $barang_id = $item['id'];
    $jumlah = $item['jumlah'];
    $subtotal = $item['subtotal'];

    // Simpan detail transaksi
    mysqli_query($conn, "
        INSERT INTO detail_transaksi
        (transaksi_id, barang_id, jumlah, subtotal)
        VALUES
        ('$transaksi_id', '$barang_id', '$jumlah', '$subtotal')
    ");

    // Kurangi stok barang
    mysqli_query($conn, "
        UPDATE barang
        SET stok = stok - $jumlah
        WHERE id = '$barang_id'
    ");
}

// Hitung kembalian
$kembalian = $bayar - $total;

// Kosongkan keranjang
unset($_SESSION['keranjang']);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Berhasil</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Transaksi Berhasil</h3>
        </div>

        <div class="card-body">

            <h5>Total Belanja:</h5>
            <p class="fs-4">
                Rp<?= number_format($total); ?>
            </p>

            <h5>Uang Bayar:</h5>
            <p class="fs-4">
                Rp<?= number_format($bayar); ?>
            </p>

            <h5>Kembalian:</h5>
            <p class="fs-4 text-success">
                Rp<?= number_format($kembalian); ?>
            </p>

            <a href="kasir.php" class="btn btn-primary w-100">
                Kembali ke Kasir
            </a>

        </div>

    </div>

</div>

</body>
</html>