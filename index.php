<?php
$conn = new mysqli("localhost", "root", "", "perpustakaan");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $penerbit = $_POST["penerbit"];
    $tahun = $_POST["tahun"];
    $kategori = $_POST["kategori"];
    $deskripsi = $_POST["deskripsi"];
    $stmt = $conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun, kategori, deskripsi) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $judul, $penulis, $penerbit, $tahun, $kategori, $deskripsi);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    $conn->query("DELETE FROM buku WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Perpustakaan</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #bbb;
        }
        th, td {
            padding: 10px;
        }
        a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📚 Sistem Informasi Perpustakaan</h1>

    <form method="post">
        <label>Judul:</label>
        <input type="text" name="judul" required>
        
        <label>Penulis:</label>
        <input type="text" name="penulis" required>
        
        <label>Penerbit:</label>
        <input type="text" name="penerbit">
        
        <label>Tahun:</label>
        <input type="number" name="tahun">
        
        <label>Kategori:</label>
        <select name="kategori">
            <option value="Fiksi">Fiksi</option>
            <option value="Non-Fiksi">Non-Fiksi</option>
            <option value="Teknologi">Teknologi</option>
            <option value="Referensi">Referensi</option>
        </select>
        
        <label>Deskripsi:</label>
        <textarea name="deskripsi"></textarea>
        
        <input type="submit" value="Simpan Buku">
    </form>

    <h2>📄 Daftar Buku</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $result = $conn->query("SELECT * FROM buku ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['judul']}</td>
                    <td>{$row['penulis']}</td>
                    <td>{$row['penerbit']}</td>
                    <td>{$row['tahun']}</td>
                    <td>{$row['kategori']}</td>
                    <td><a href='?hapus={$row['id']}' onclick=\"return confirm('Hapus data ini?')\">Hapus</a></td>
                  </tr>";
            $no++;
        }
        ?>
    </table>
</div>
</body>
</html>
