<?php
include "koneksi.php";
include "upload_foto.php";
?>

<h3>Manajemen Gallery</h3>

<div class="row mb-3">
    <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Gallery
        </button>
    </div>
    <div class="col-md-6">
        <input type="text" id="search" class="form-control" placeholder="Cari gallery...">
    </div>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="result"></tbody>
</table>

<script>
function loadData(keyword = '') {
    $.post("gallery_search.php", {keyword: keyword}, function(data){
        $("#result").html(data);
    });
}
loadData();

$("#search").on("keyup", function(){
    loadData(this.value);
});
</script>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
<div class="modal-dialog">
<div class="modal-content">
<form method="post" enctype="multipart/form-data">
<div class="modal-header">
    <h5>Tambah Gallery</h5>
</div>
<div class="modal-body">
    <input type="text" name="deskripsi" class="form-control mb-2" placeholder="Deskripsi" required>
    <input type="file" name="gambar" class="form-control" required>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button class="btn btn-primary" name="simpan">Simpan</button>
</div>
</form>
</div>
</div>
</div>

<?php
// SIMPAN
if (isset($_POST['simpan'])) {
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];

    $upload = upload_foto($_FILES['gambar']);
    if (!$upload['status']) {
        echo "<script>alert('".$upload['message']."')</script>";
        exit;
    }
    $gambar = $upload['message'];

    $stmt = $conn->prepare("INSERT INTO gallery (deskripsi,gambar,tanggal,username) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$deskripsi,$gambar,$tanggal,$username);
    $stmt->execute();

    echo "<script>location='admin.php?page=gallery'</script>";
}

// HAPUS
if (isset($_POST['hapus'])) {
    unlink("img/".$_POST['gambar']);

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
    $stmt->bind_param("i",$_POST['id']);
    $stmt->execute();

    echo "<script>location='admin.php?page=gallery'</script>";
}
?>
