<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include('config/koneksi.php');

// Initialize $error variable
$error = '';

if (isset($_POST['submit'])) {
    // Get form inputs
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    // Ensure no fields are empty
    if (!empty($nama) && !empty($umur) && !empty($alamat) && !empty($deskripsi) && !empty($kategori)) {
        // Use prepared statement to prevent SQL Injection
        $stmt = $koneksi->prepare("INSERT INTO pegawai (nama, umur, alamat, deskripsi, kategori) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $nama, $umur, $alamat, $deskripsi, $kategori);

        // Execute query
        if ($stmt->execute()) {
            // Redirect to index after successful insertion
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal menambahkan data!";
        }

        $stmt->close();
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">List Pegawai</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tambah.php' ? 'active' : '' ?>" href="tambah.php">Add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Form Tambah Pegawai -->
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <h3 class="mb-4">Tambah Pegawai</h3>
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur</label>
                    <input type="number" id="umur" name="umur" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" required>
                </div>
                <div class="mb-3 form-group">
                    <label>Kategori</label>
                    <select class="form-select" name="kategori" required>
                        <option selected disabled>Open this select menu</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Part Time">Part Time</option>
                        <option value="Full Time">Full Time</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary" type="submit" name="submit">Tambah</button>
                </div>
            </form>
            <!-- Display error message if exists -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mt-3"><?= $error ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
