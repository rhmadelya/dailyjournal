<?php
include "koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user yang sedang login
$sql_user = "SELECT username, foto FROM user WHERE username='$username'";
$hasil_user = $conn->query($sql_user);
if (!$hasil_user) {
    die("Query user gagal: " . $conn->error);
}
$user = $hasil_user->fetch_assoc();

// Ambil jumlah artikel
$sql_article = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil_article = $conn->query($sql_article);
if (!$hasil_article) {
    die("Query article gagal: " . $conn->error);
}
$jumlah_article = $hasil_article->num_rows;

// Ambil jumlah gallery
$sql_gallery = "SELECT * FROM gallery ORDER BY id DESC"; // ganti 'id' sesuai nama kolom PK di gallery
$hasil_gallery = $conn->query($sql_gallery);
if (!$hasil_gallery) {
    die("Query gallery gagal: " . $conn->error);
}
$jumlah_gallery = $hasil_gallery->num_rows;
?>

<!-- Row Foto Profil -->
<div class="row justify-content-center pt-4">
    <div class="col-auto text-center">
        <?php if ($user['foto'] != ''): ?>
            <img src="uploads/<?= $user['foto'] ?>" 
                 width="120" class="rounded-circle mb-2 border border-3 border-danger shadow">
        <?php else: ?>
            <i class="bi bi-person-circle fs-1 text-danger mb-2"></i>
        <?php endif; ?>
        <h5 class="mt-2"><?= $user['username'] ?></h5>
        <p class="text-muted">Sedang login</p>
    </div>
</div>

<!-- Row Card Article & Gallery -->
<div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center pt-4">
    <!-- Card Article -->
    <div class="col d-flex">
        <div class="card border border-danger mb-3 shadow flex-fill">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                <span class="badge rounded-pill text-bg-danger fs-2"><?= $jumlah_article ?></span>
            </div>
        </div>
    </div> 

    <!-- Card Gallery -->
    <div class="col d-flex">
        <div class="card border border-danger mb-3 shadow flex-fill">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                <span class="badge rounded-pill text-bg-danger fs-2"><?= $jumlah_gallery ?></span>
            </div>
        </div>
    </div> 
</div>
