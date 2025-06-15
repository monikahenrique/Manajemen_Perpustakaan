<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h2>Form Tambah Buku</h2>
    <form name="formBuku" action="proses_tambah.php" method="post" onsubmit="return validateForm()">
        <label>Judul:</label>
        <input type="text" name="judul"><br><br>

        <label>Penulis:</label>
        <input type="text" name="penulis"><br><br>

        <label>Penerbit:</label>
        <input type="text" name="penerbit"><br><br>

        <label>Tahun Terbit:</label>
        <input type="number" name="tahun"><br><br>

        <label>Kategori:</label>
        <select name="kategori">
            <option value="Fiksi">Fiksi</option>
            <option value="Non-Fiksi">Non-Fiksi</option>
            <option value="Ilmiah">Ilmiah</option>
            <option value="Referensi">Referensi</option>
        </select><br><br>

        <label>Deskripsi:</label>
        <textarea name="deskripsi"></textarea><br><br>

        <input type="submit" value="Simpan Buku">
    </form>
    <br><a href="index.php">← Kembali</a>
</body>
</html>
