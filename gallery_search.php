<?php
include "koneksi.php";

$keyword = $_POST['keyword'] ?? '';

$stmt = $conn->prepare("SELECT * FROM gallery WHERE deskripsi LIKE ? ORDER BY id DESC");
$search = "%$keyword%";
$stmt->bind_param("s",$search);
$stmt->execute();
$result = $stmt->get_result();

$no=1;
while($row=$result->fetch_assoc()){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['deskripsi'] ?></td>
    <td>
        <img src="img/<?= $row['gambar'] ?>" width="120">
    </td>
    <td>
        <form method="post" action="admin.php?page=gallery">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="gambar" value="<?= $row['gambar'] ?>">
            <button name="hapus" class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
</tr>
<?php } ?>
