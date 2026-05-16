<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Tambah barang ke keranjang
if (isset($_POST['tambah'])) {

    $id_barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];

    $query = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id_barang'");
    $barang = mysqli_fetch_assoc($query);

    if ($barang) {

        $subtotal = $barang['harga'] * $jumlah;

        $_SESSION['keranjang'][] = [
            'id' => $barang['id'],
            'nama_barang' => $barang['nama_barang'],
            'harga' => $barang['harga'],
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];
    }
}

// Hitung total
$total = 0;

foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS AntiGravity</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Kasir POS AntiGravity</h3>
        </div>

        <div class="card-body">

            <!-- FORM TAMBAH -->
            <form method="POST">

                <div class="row">

                    <div class="col-md-5 mb-3">
                        <label class="form-label">Pilih Barang</label>

                        <select name="barang" class="form-select" required>

                            <option value="">-- Pilih Barang --</option>

                            <?php
                            $barang = mysqli_query($conn, "SELECT * FROM barang");

                            while ($b = mysqli_fetch_assoc($barang)) {
                            ?>

                                <option value="<?= $b['id']; ?>">
                                    <?= $b['nama_barang']; ?> - Rp<?= number_format($b['harga']); ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jumlah</label>

                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>

                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <button type="submit" name="tambah" class="btn btn-primary w-100">
                            Tambah ke Keranjang
                        </button>
                    </div>

                </div>

            </form>

            <hr>

            <!-- TABEL KERANJANG -->
            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (!empty($_SESSION['keranjang'])) : ?>

                            <?php
                            $no = 1;

                            foreach ($_SESSION['keranjang'] as $index => $item) :
                            ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td><?= $item['nama_barang']; ?></td>

                                    <td>
                                        Rp<?= number_format($item['harga']); ?>
                                    </td>

                                    <td><?= $item['jumlah']; ?></td>

                                    <td>
                                        Rp<?= number_format($item['subtotal']); ?>
                                    </td>

                                    <td>
                                        <a href="hapus_item.php?index=<?= $index; ?>"
                                            class="btn btn-danger btn-sm">
                                            Hapus
                                        </a>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <tr>
                                <td colspan="6" class="text-center">
                                    Keranjang Masih Kosong
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="4" class="text-end">
                                Total Harga
                            </th>

                            <th colspan="2">
                                Rp<?= number_format($total); ?>
                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

            <!-- PEMBAYARAN -->
            <?php if (!empty($_SESSION['keranjang'])) : ?>

                <div class="card mt-4">

                    <div class="card-header bg-success text-white">
                        Pembayaran
                    </div>

                    <div class="card-body">

                        <form action="proses_transaksi.php" method="POST">

                            <input type="hidden" name="total" value="<?= $total; ?>">

                            <div class="mb-3">

                                <label class="form-label">
                                    Uang Bayar
                                </label>

                                <input
                                    type="number"
                                    name="bayar"
                                    id="bayar"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Kembalian
                                </label>

                                <input
                                    type="text"
                                    id="kembalian"
                                    class="form-control"
                                    readonly>

                            </div>

                            <button class="btn btn-success w-100">
                                Checkout
                            </button>

                        </form>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS -->
<script src="assets/js/script.js"></script>

<script>

let bayar = document.getElementById('bayar');

if (bayar) {

    bayar.addEventListener('input', function () {

        let total = <?= $total; ?>;
        let uang = this.value;

        let kembali = uang - total;

        document.getElementById('kembalian').value = kembali;

    });

}

</script>

</body>
</html>