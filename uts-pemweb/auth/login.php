<?php
session_start();
require "../config/koneksi.php";

// CEK POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid (405)");
}

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (!$email || !$password) {
    die("Email dan password wajib diisi!");
}

$sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header("Location: ../pages/menu.php");
    exit;

} else {
    echo "<script>alert('Email atau password salah!'); 
          window.location='../login.html';</script>";
}
?>
