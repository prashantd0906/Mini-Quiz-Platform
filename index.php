<?php
session_start();
require_once 'admin/db.php';

$error = "";
$db = new dbConnection('127.0.0.1', 'root', '', 'quiz_db');
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $name = $_POST['name'] ?? '';
    $password = md5($_POST['password'] ?? ''); // Hash input using md5

    if (empty($name) || empty($password)) {
        $error = "Both name and password are required.";
    } else {
        $name = $conn->real_escape_string($name);
        $password = $conn->real_escape_string($password);

        $sql = "SELECT * FROM users WHERE name = '$name' AND password = '$password' LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['loggedin'] = true;

            if ($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: quiz.php');
            }
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h3 class="text-center mb-3">Login</h3>
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name">
                    <label class="form-label mt-3">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter the password">
                </div>
                <button type="submit" name="login" class="btn btn-secondary w-100">Login</button>
                <a href="register.php" class="btn btn-outline-primary w-100 mt-2">Go to Register</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
