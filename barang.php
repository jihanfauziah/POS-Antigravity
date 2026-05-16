<?php
include '../koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h3 class="mb-0">Data Barang</h3>

            <a href="tambah_barang.php" class="btn btn-light">
                Tambah Barang
            </a>

        </div>

        <div class="card-body">

            <a href="../kasir.php" class="btn btn-success mb-3">
                Kembali ke Kasir
            </a>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    while($row = mysqli_fetch_assoc($data)){
                    ?>

                        <tr>

                            <td><?php echo $no++; ?></td>

                            <td><?php echo $row['nama_barang']; ?></td>

                            <td>
                                Rp<?php echo number_format($row['harga']); ?>
                            </td>

                            <td><?php echo $row['stok']; ?></td>

                            <td>

                                <a href="edit_barang.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <a href="hapus_barang.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin hapus?')">

                                    Hapus

                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>