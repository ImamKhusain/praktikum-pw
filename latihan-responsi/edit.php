<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'config/koneksi.php';

// Get employee data based on ID from URL
$id = $_GET['id'];
$query = "SELECT * FROM pegawai WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$pegawai = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    // Get form data
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    // Check if fields are not empty
    if (!empty($nama) && !empty($umur) && !empty($alamat) && !empty($deskripsi) && !empty($kategori)) {
        // Directly include variables in SQL query (unsafe)
        $query = "UPDATE pegawai SET nama = '$nama', umur = '$umur', alamat = '$alamat', deskripsi = '$deskripsi', kategori_id = '$kategori' WHERE id = $id";
        
        if (mysqli_query($koneksi, $query)) {
            // Redirect to index after successful update
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal mengupdate data!";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai</title>
</head>
<body>
    <h1>Edit Pegawai</h1>
    <form method="POST">
        Nama: <input type="text" name="nama" value="<?= $pegawai['nama'] ?>"><br>
        Umur: <input type="number" name="umur" value="<?= $pegawai['umur'] ?>"><br>
        Alamat: <input type="text" name="alamat" value="<?= $pegawai['alamat'] ?>"><br>
        Deskripsi: <textarea name="deskripsi"><?= $pegawai['deskripsi'] ?></textarea><br>
        Kategori:
        <select class="form-select" name="kategori" required>
            <option value="">Open this select menu</option>
            <option value="1" <?= $pegawai['kategori'] == 1 ? 'selected' : '' ?>>Freelance</option>
            <option value="2" <?= $pegawai['kategori'] == 2 ? 'selected' : '' ?>>Part Time</option>
            <option value="3" <?= $pegawai['kategori'] == 3 ? 'selected' : '' ?>>Full Time</option>
        </select><br>
        <button type="submit" name="update">Update</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
