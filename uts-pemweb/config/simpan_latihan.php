<?php
session_start();
include "../config/db.php";

$user_id = $_SESSION['user_id'];
$kategori = $_POST['kategori'];
$skor = $_POST['skor'];
$tanggal = date("Y-m-d");

$sql = "INSERT INTO latihan_harian(user_id, tanggal, skor, kategori)
        VALUES('$user_id', '$tanggal', '$skor', '$kategori')";
mysqli_query($conn, $sql);

header("Location: ../pages/dashboard.php");
?>
