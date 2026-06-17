<?php
session_start();

include '../config/db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare(
        "UPDATE posts SET title=?, content=? WHERE id=?"
    );

    $stmt->bind_param("ssi", $title, $content, $id);

    $stmt->execute();

    header("Location: view.php");
    exit();
}

$stmt = $conn->prepare(
    "SELECT * FROM posts WHERE id=?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$post = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form method="POST">

    <input type="text"
           name="title"
           value="<?php echo htmlspecialchars($post['title']); ?>"
           required>

    <br><br>

    <textarea name="content"
              rows="5"
              cols="40"
              required><?php echo htmlspecialchars($post['content']); ?></textarea>

    <br><br>

    <button type="submit">Update Post</button>

</form>

</body>
</html>