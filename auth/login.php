<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Store role in session
            $_SESSION['role'] = $user['role'];

            header("Location: ../dashboard.php");
            exit();

        } else {
            $message = "Invalid Password";
        }

    } else {
        $message = "User Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2>Login</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Username"
                required>
        </div>

        <div class="mb-3">
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required>
        </div>

        <button type="submit" class="btn btn-primary">
            Login
        </button>

    </form>

</div>

</body>
</html>