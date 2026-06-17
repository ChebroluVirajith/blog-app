<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side Validation
    if (strlen($title) < 3) {
        $message = "Title must be at least 3 characters long.";
        $messageType = "danger";
    }
    elseif (strlen($content) < 10) {
        $message = "Content must be at least 10 characters long.";
        $messageType = "danger";
    }
    else {

        $stmt = $conn->prepare(
            "INSERT INTO posts (title, content) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {
            $message = "Post Created Successfully!";
            $messageType = "success";
        } else {
            $message = "Error creating post.";
            $messageType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4">Create New Post</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Post Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                required
                minlength="3"
                placeholder="Enter post title">
        </div>

        <div class="mb-3">
            <label class="form-label">Post Content</label>

            <textarea
                name="content"
                class="form-control"
                rows="6"
                required
                minlength="10"
                placeholder="Enter post content"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            Create Post
        </button>

        <a href="view.php" class="btn btn-primary">
            View Posts
        </a>

        <a href="../dashboard.php" class="btn btn-secondary">
            Dashboard
        </a>

    </form>

</div>

</body>
</html>