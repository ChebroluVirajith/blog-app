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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">
        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </h1>

    <a href="posts/create.php" class="btn btn-success me-2">
        Create Post
    </a>

    <a href="posts/view.php" class="btn btn-primary me-2">
        View Posts
    </a>

    <a href="auth/logout.php" class="btn btn-danger">
        Logout
    </a>

</div>

</body>
</html>