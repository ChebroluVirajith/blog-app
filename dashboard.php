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

    <div class="card shadow">
        <div class="card-body">

            <h1 class="mb-3">
                Welcome,
                <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </h1>

            <p class="fs-5">
                Role:
                <strong class="text-primary">
                    <?php
                    echo isset($_SESSION['role'])
                        ? htmlspecialchars($_SESSION['role'])
                        : 'Not Assigned';
                    ?>
                </strong>
            </p>

            <hr>

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
    </div>

</div>

</body>
</html>