<?php
include 'config.php';

$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];

$stmt = $conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun, kategori, deskripsi) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $judul, $penulis, $penerbit, $tahun, $kategori, $deskripsi);
$stmt->execute();

header("Location: index.php");
?>
