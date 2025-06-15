<?php
session_start();
$conn = new mysqli("localhost","root","","perpustakaan");
if($conn->connect_error) die("Koneksi gagal: ".$conn->connect_error);

// Proses login
if(isset($_POST['login'])){
  $u=$_POST['user']; $p=sha1($_POST['pass']);
  $r=$conn->query("SELECT * FROM anggota WHERE username='$u' AND password='$p'");
  if($r->num_rows>0){ $_SESSION['user'] = $u; }
  else $err = "Login gagal!";
}

// Logout
if(isset($_GET['logout'])){ session_destroy(); header('Location: index.php'); exit; }

// Proses pinjam
if(isset($_POST['pinjam']) && isset($_SESSION['user'])){
  $a=$conn->query("SELECT id FROM anggota WHERE username='{$_SESSION['user']}'")->fetch_assoc()['id'];
  $b=(int)$_POST['id_buku'];
  $t1 = $_POST['tgl_pinjam']; $t2 = $_POST['tgl_kembali'];
  $conn->query("INSERT INTO pinjam(id_anggota,id_buku,tgl_pinjam,tgl_kembali) VALUES($a,$b,'$t1','$t2')");
  $conn->query("UPDATE buku SET status='Dipinjam' WHERE id=$b");
}

// Tambah buku (admin demo)
if(isset($_POST['tambah_buku'])){
  $conn->query(sprintf(
    "INSERT INTO buku(judul,penulis,kategori) VALUES('%s','%s','%s')",
    $_POST['judul'],$_POST['penulis'],$_POST['kategori']
  ));
}
?>
<!DOCTYPE html>
<html><head>
  <meta charset="utf-8"><title>Perpustakaan</title>
  <style>body{font-family:sans-serif;background:#f0f4f8;margin:0;padding:0}
.container{max-width:900px;margin:auto;background:white;padding:20px;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,0.1)}
nav a{margin:0 10px;text-decoration:none;color:#3f51b5;font-weight:bold}
input,select{width:100%;margin-bottom:12px;padding:8px}
.btn{background:#3f51b5;color:white;padding:8px 12px;border:none;cursor:pointer}
.btn:hover{background:#303f9f}
table{width:100%;border-collapse:collapse;margin-top:12px}
th,td{border:1px solid #ddd;padding:8px}th{background:#3f51b5;color:white}
section{margin-top:30px}
.alert{color:red}
</style>
</head><body>
<div class="container">
  <h1>📚 E-Perpustakaan</h1>
  <nav>
    <a href="#katalog">Katalog</a>
    <a href="#pinjam">Peminjaman</a>
    <?php if(isset($_SESSION['user'])): ?>
      <a href="?logout=1">Logout</a>
    <?php else: ?>
      <a href="#login">Login</a>
    <?php endif ?>
  </nav>

  <?php if(isset($err)): ?><p class="alert"><?=$err?></p><?php endif ?>

  <?php if(!isset($_SESSION['user'])): ?>
  <section id="login">
    <h2>Login Anggota</h2>
    <form method="post">
      <input name="user" placeholder="Username" required>
      <input name="pass" type="password" placeholder="Password" required>
      <button class="btn" name="login">Login</button>
    </form>
  </section>
  <?php else: ?>
  <p>Hai, <strong><?=htmlspecialchars($_SESSION['user'])?></strong>!</p>
  <?php endif ?>

  <section id="katalog">
    <h2>Katalog Buku</h2>
    <table><tr><th>#</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Status</th><?php if(isset($_SESSION['user'])) echo '<th>Aksi</th>'; ?></tr>
      <?php
      $i=1;$q=$conn->query("SELECT * FROM buku");
      while($row=$q->fetch_assoc()):
      ?>
      <tr>
        <td><?=$i++?></td><td><?=htmlspecialchars($row['judul'])?></td><td><?=htmlspecialchars($row['penulis'])?></td>
        <td><?=htmlspecialchars($row['kategori'])?></td><td><?=$row['status']?></td>
        <?php if(isset($_SESSION['user'])): ?>
          <td><?php if($row['status']=='Tersedia'): ?>
            <button onclick="document.getElementById('pinjam-id').value=<?=$row['id']?>;location='#pinjam'">Pinjam</button>
          <?php endif?></td>
        <?php endif ?>
      </tr>
      <?php endwhile ?>
    </table>

    <?php if(isset($_SESSION['user'])): ?>
    <h3>Tambah Buku (Demo admin)</h3>
    <form method="post">
      <input name="judul" placeholder="Judul Buku" required>
      <input name="penulis" placeholder="Penulis" required>
      <select name="kategori" required>
        <option>Fiksi</option><option>Non-Fiksi</option><option>Teknologi</option><option>Sejarah</option><option>Komik</option>
      </select>
      <button class="btn" name="tambah_buku">Tambah Buku</button>
    </form>
    <?php endif ?>
  </section>

  <section id="pinjam">
    <h2>Peminjaman Buku</h2>
    <?php if(!isset($_SESSION['user'])): ?>
      <p>Login terlebih dahulu untuk meminjam buku.</p>
    <?php else: ?>
    <form method="post">
      <input type="hidden" name="id_buku" id="pinjam-id" required>
      <input type="date" name="tgl_pinjam" required>
      <input type="date" name="tgl_kembali" required>
      <button class="btn" name="pinjam">Pinjam Sekarang</button>
    </form>
    <?php endif ?>
  </section>

  <section id="laporan">
    <h2>📊 Statistik</h2>
    <ul>
      <li>Total Buku: <?=$conn->query("SELECT COUNT(*) FROM buku")->fetch_row()[0]?></li>
      <li>Total Anggota: <?=$conn->query("SELECT COUNT(*) FROM anggota")->fetch_row()[0]?></li>
      <li>Peminjaman Aktif: <?=$conn->query("SELECT COUNT(*) FROM pinjam")->fetch_row()[0]?></li>
    </ul>
  </section>
</div>
</body></html>
