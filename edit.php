<?php include 'config.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM buku WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Buku</h2>
    <form action="" method="post">
        <label>Judul:</label>
        <input type="text" name="judul" value="<?= $data['judul'] ?>"><br><br>

        <label>Penulis:</label>
        <input type="text" name="penulis" value="<?= $data['penulis'] ?>"><br><br>

        <label>Penerbit:</label>
        <input type="text" name="penerbit" value="<?= $data['penerbit'] ?>"><br><br>

        <label>Tahun:</label>
        <input type="number" name="tahun" value="<?= $data['tahun'] ?>"><br><br>

        <label>Kategori:</label>
        <input type="text" name="kategori" value="<?= $data['kategori'] ?>"><br><br>

        <label>Deskripsi:</label>
        <textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea><br><br>

        <input type="submit" name="update" value="Update Buku">
    </form>
    <br><a href="index.php">← Kembali</a>

<?php
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun=?, kategori=?, deskripsi=? WHERE id=?");
    $stmt->bind_param("sssissi", $_POST['judul'], $_POST['penulis'], $_POST['penerbit'], $_POST['tahun'], $_POST['kategori'], $_POST['deskripsi'], $id);
    $stmt->execute();
    header("Location: index.php");
}
?>
</body>
</html>
