<?php
include '../koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id'");

$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "UPDATE barang SET
    nama_barang='$nama',
    harga='$harga',
    stok='$stok'
    WHERE id='$id'");

    header("Location: barang.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header bg-warning">
            Edit Barang
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Nama Barang</label>

                    <input type="text"
                    name="nama_barang"
                    class="form-control"
                    value="<?php echo $row['nama_barang']; ?>"
                    required>
                </div>

                <div class="mb-3">
                    <label>Harga</label>

                    <input type="number"
                    name="harga"
                    class="form-control"
                    value="<?php echo $row['harga']; ?>"
                    required>
                </div>

                <div class="mb-3">
                    <label>Stok</label>

                    <input type="number"
                    name="stok"
                    class="form-control"
                    value="<?php echo $row['stok']; ?>"
                    required>
                </div>

                <button type="submit"
                name="update"
                class="btn btn-warning w-100">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>