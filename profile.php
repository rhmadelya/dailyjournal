<?php
session_start();
include "koneksi.php";

$username = $_SESSION['username'];

// ambil data user yg sedang login
$stmt = $conn->prepare("SELECT username, password, foto FROM user WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<div class="bg-danger-subtle p-4 rounded shadow-sm">
<div class="card shadow-sm border border-danger-subtle">
    <div class="card-body p-4 rounded-4">
        <div class="bg-danger-subtle p-3 rounded mb-4">
        <h4 class="fw-bold text-danger mb-0">Profile Saya</h4>
    </div>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
            </div>

            <div class="mb-3">
                <label>Foto Profil</label><br>
                <?php if ($user['foto'] != ''): ?>
                    <img src="../uploads/<?= $user['foto'] ?>" 
                        width="120" 
                        class="mb-3 rounded-circle shadow border border-3 border-danger">
                <?php endif; ?>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" name="update" class="btn btn-danger">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
</div>

<?php
if (isset($_POST['update'])) {

    $password = $_POST['password'];

    // proses foto
    $foto = $user['foto'];
    if ($_FILES['foto']['name'] != '') {
        $nama = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $nama);
        $foto = $nama;
    }

    if ($password != '') {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET password=?, foto=? WHERE username=?");
        $stmt->bind_param("sss", $password, $foto, $username);
    } else {
        $stmt = $conn->prepare("UPDATE user SET foto=? WHERE username=?");
        $stmt->bind_param("ss", $foto, $username);
    }

    $stmt->execute();

    echo "<script>
        alert('Profile berhasil diperbarui');
        document.location='admin.php?page=profile';
    </script>";
}
?>
