<?php
include '../koneksi.php';

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "INSERT INTO barang (nama_barang, harga, stok)
    VALUES ('$nama','$harga','$stok')");

    header("Location: barang.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header bg-success text-white">
            Tambah Barang
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Nama Barang</label>

                    <input type="text"
                    name="nama_barang"
                    class="form-control"
                    required>
                </div>

                <div class="mb-3">
                    <label>Harga</label>

                    <input type="number"
                    name="harga"
                    class="form-control"
                    required>
                </div>

                <div class="mb-3">
                    <label>Stok</label>

                    <input type="number"
                    name="stok"
                    class="form-control"
                    required>
                </div>

                <button type="submit"
                name="simpan"
                class="btn btn-success w-100">

                    Simpan

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>