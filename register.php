<?php
session_start();
require_once 'admin/db.php';

$error = "";
$db = new dbConnection('127.0.0.1', 'root', '', 'quiz_db');
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($name) || empty($password)) {
        $error = "Both name and password are required.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $name)) {
        $error = "Username must be 3-20 characters with only letters, numbers, or underscores.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{5,20}$/', $password)) {
        $error = "Password must be 5-20 characters with letters, numbers, and allowed special characters";
    } else {
        // Escape inputs
        $name = $conn->real_escape_string($name);
        $password = md5($password);
        $password = $conn->real_escape_string($password);

        // Check if user exists
        $sql = "SELECT id FROM users WHERE name = '$name' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $error = "User already registered. Please login.";
        } else {
            $insert = "INSERT INTO users (name, password, role) VALUES ('$name', '$password', 'user')";
            if ($conn->query($insert)) {
                $_SESSION['name'] = $name;
                setcookie('username', $name, time() + (7 * 24 * 60 * 60), "/");
                header("Location: index.php");
                exit;
            } else {
                $error = "Error during registration.";
            }
        }
    }
}
?>

<html>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<body class="bg-light">
    <div class="container mt-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-5">Register</h2>
                <?php if ($error != ""): ?>
                    <div class="alert alert-danger text-center"><?= $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter a password">
                    </div>
                    <button type="submit" name="register" class="btn btn-secondary w-100">Register</button>
                    <a href="index.php" class="btn btn-outline-primary w-100 mt-2">Go to Login</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
