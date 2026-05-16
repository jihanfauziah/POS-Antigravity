<?php

$conn = mysqli_connect("localhost", "root", "", "pos_antigravity");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>