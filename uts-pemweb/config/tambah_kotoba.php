<?php
session_start();
include "../config/db.php";

$user_id = $_SESSION['user_id'];
$kotoba = $_POST['kotoba'];
$arti = $_POST['arti'];

$sql = "INSERT INTO kotoba_custom(user_id, kotoba, arti) 
        VALUES('$user_id', '$kotoba', '$arti')";
mysqli_query($conn, $sql);

header("Location: ../pages/kotoba_user.php");
?>
