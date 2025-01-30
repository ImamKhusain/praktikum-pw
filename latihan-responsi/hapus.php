<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include('koneksi.php');

$id = $_GET['id'];
$query = "DELETE FROM pegawai WHERE id = $id";
mysqli_query($koneksi, $query);
header("Location: index.php");
?>
