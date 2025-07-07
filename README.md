# Mini-Quiz-Platform - HOME.php is my main file

Steps to run this project locally in your system.

Step1: Download the xampp in your local machine.
https://www.apachefriends.org/download.html

Step2: Clone this project into your machine.
https://github.com/prashantd0906/Mini-Quiz-Platform.git

Step3: Unzip the folder and paste the entire folder inside the below given path:
Application -> xampp -> xamppfile -> htdocs -> "paste the folder"

Step4: Download and install mysql in your local machine either by your terminal or through the below link:
https://www.mysql.com/downloads/

Step5: Once all setup is completed, dont forgot to run the xampp server
Apache server -> start
Mysql -> start

Step6: Project folder:
admin
classes
css
.DS_Store
README.md
home.php
index.php
logout.php
questions.php
quiz.php
quiz.sql
register.php
result.php

Step7: Remember Home.php is our main file. 
Step8: In quiz.sql file, all the queries has been saved, which you can follow in phpmyadmin to complete your project schema.

Step9: Run the project in your browser:
https://localhost/home.php

HAPPY CODING !

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


---------------

adminLogin.php

<?php
session_start();
require_once '../classes/UserManager.php';

$db = new dbConnection('127.0.0.1', 'root', '', 'quiz_db');
$conn = $db->getConnection();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $password = md5($_POST['password'] ?? '');

    $query = "SELECT id, name, password FROM users WHERE name='$name' AND password='$password' AND role='admin'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $_SESSION['admin'] = $name;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>

<html>
<head>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="border p-4 bg-white" style="width: 100%; max-width: 350px;">
        <h5 class="mb-3 text-center">Admin Login</h5>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" required placeholder="Username">

            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" required placeholder="Password">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
