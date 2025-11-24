<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}
?>
<h1>Halo, <?= $_SESSION['username']; ?>!</h1>
<p>Selamat datang di menu pembelajaran Nihongo.</p>
