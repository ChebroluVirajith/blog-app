<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    die("Access Denied");
}
include '../config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare(
    "DELETE FROM posts WHERE id=?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: view.php");
exit();
?>