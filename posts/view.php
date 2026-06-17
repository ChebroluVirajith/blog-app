<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$search = "";

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {

    $search = trim($_GET['search']);
    $keyword = "%" . $search . "%";

    $countStmt = $conn->prepare(
        "SELECT COUNT(*) as total
         FROM posts
         WHERE title LIKE ? OR content LIKE ?"
    );

    $countStmt->bind_param("ss", $keyword, $keyword);
    $countStmt->execute();

    $totalRows = $countStmt
        ->get_result()
        ->fetch_assoc()['total'];

    $stmt = $conn->prepare(
        "SELECT *
         FROM posts
         WHERE title LIKE ? OR content LIKE ?
         ORDER BY created_at DESC
         LIMIT ? OFFSET ?"
    );

    $stmt->bind_param(
        "ssii",
        $keyword,
        $keyword,
        $limit,
        $offset
    );

    $stmt->execute();
    $result = $stmt->get_result();

} else {

    $totalResult = $conn->query(
        "SELECT COUNT(*) as total FROM posts"
    );

    $totalRows =
        $totalResult->fetch_assoc()['total'];

    $result = $conn->query(
        "SELECT *
         FROM posts
         ORDER BY created_at DESC
         LIMIT $limit OFFSET $offset"
    );
}

$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4">All Posts</h2>

    <div class="mb-3">
        <a href="create.php" class="btn btn-success">
            Create New Post
        </a>

        <a href="../dashboard.php" class="btn btn-secondary">
            Dashboard
        </a>
    </div>

    <form method="GET" class="mb-4">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search posts..."
            value="<?php echo htmlspecialchars($search); ?>">

        <button class="btn btn-primary mt-2">
            Search
        </button>

    </form>

    <?php if ($result->num_rows > 0): ?>

        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="card mb-3">

                <div class="card-body">

                    <h4 class="card-title">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h4>

                    <p class="card-text">
                        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                    </p>

                    <small class="text-muted">
                        <?php echo $row['created_at']; ?>
                    </small>

                    <br><br>

                    <a
                        href="edit.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                 <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

<a
href="delete.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this post?')">
Delete
</a>

<?php endif; ?>

                </div>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="alert alert-info">
            No posts found.
        </div>

    <?php endif; ?>

    <nav>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

            <a
                href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                class="btn btn-outline-primary m-1">

                <?php echo $i; ?>

            </a>

        <?php endfor; ?>

    </nav>

</div>

</body>
</html>