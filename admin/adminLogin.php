<?php
session_start();
require_once '../classes/UserManager.php';

$db = new dbConnection('127.0.0.1','root','','quiz_db'); 
$conn = $db->getConnection();  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($query); //query(): send SQL statements to the database.


if ($result->num_rows === 1) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
    die;
    } else {
        echo "Invalid login.";
    }
}
?>

<html>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="border p-4 bg-white" style="width: 100%; max-width: 350px;">
        <h5 class="mb-3 text-center">Admin Login</h5>
        
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" required placeholder="Username">
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

