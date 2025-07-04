<?php
session_start();
require_once 'admin/db.php';

$error = "";
$db = new dbConnection('127.0.0.1', 'root', '', 'quiz_db');
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $name = $_POST['name'] ?? '';
    $password = ($_POST['password'] ?? '');

    if (empty($name) || empty($password)) {
        $error = "Both name and password are required.";
    } else {
        $name = $conn->real_escape_string($name);

        $sql = "SELECT * FROM users WHERE name = '$name' AND password = '$password' LIMIT 1";

        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Only allow non-admin users to log in
            if ($user['role'] !== 'admin') {
                $_SESSION['name'] = $user['name'];
                $_SESSION['loggedin'] = true;

                header('Location: quiz.php');
                exit;
            } else {
                $error = "Admins must log in from the admin portal.";
            }
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
                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name">

                        <label class="form-label mt-3">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter the password">
                    </div>

                    <button type="submit" name="login" class="btn btn-secondary w-100">Login</button>

                </form>
            </div>
        </div>
    </div>

</body>

</html>