<?php
require "../config/koneksi.php";

// Cek apakah form dikirim dengan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data POST
    $username = $_POST['nama'] ?? null;
    $email    = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$username || !$email || !$password) {
        die("Form tidak lengkap!");
    }

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Query insert
    $sql = "INSERT INTO users (username, email, password) 
            VALUES (:username, :email, :password)";

    $stmt = $koneksi->prepare($sql);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hash);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil!'); window.location='../login.html';</script>";
        exit;
    } else {
        echo "Gagal menyimpan data!";
    }
} else {
    echo "Akses tidak valid (405)";
}
?>
