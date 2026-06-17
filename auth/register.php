<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username,password) VALUES (?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$username,$password);

    if($stmt->execute()){
        $message = "Registration Successful!";
    } else {
        $message = "Error: Username may already exist.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>User Registration</h2>

<form method="POST">
    Username:
    <input type="text" name="username" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    <button type="submit">Register</button>
</form>

<p><?php echo $message; ?></p>

</body>
</html>