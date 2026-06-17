<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

<a href="posts/create.php">Create Post</a>

<br><br>

<a href="posts/view.php">View Posts</a>

<br><br>

<a href="auth/logout.php">Logout</a>
</body>
</html>