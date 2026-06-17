<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        $message = "Post Created Successfully!";
    } else {
        $message = "Error creating post.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>

<h2>Create New Post</h2>

<form method="POST">
    <input type="text" name="title" placeholder="Post Title" required>
    <br><br>

    <textarea name="content" rows="5" cols="40" placeholder="Post Content" required></textarea>
    <br><br>

    <button type="submit">Create Post</button>
</form>

<p><?php echo $message; ?></p>

<br>
<a href="../dashboard.php">Dashboard</a>

</body>
</html>