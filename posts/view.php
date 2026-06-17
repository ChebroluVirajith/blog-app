<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>
</head>
<body>

<h2>All Posts</h2>

<a href="create.php">Create New Post</a>
<br><br>

<?php while($row = $result->fetch_assoc()) { ?>

    <h3><?php echo htmlspecialchars($row['title']); ?></h3>

    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>

    |

    <a href="delete.php?id=<?php echo $row['id']; ?>"
       onclick="return confirm('Delete this post?')">
       Delete
    </a>

    <hr>

<?php } ?>

</body>
</html>