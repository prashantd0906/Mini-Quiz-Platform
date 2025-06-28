<?php
session_start();
$error = "";

require_once 'admin/db.php'; // Include the database connection class
$db =  new dbConnection('127.0.0.1','root','','quiz_db'); // Create a new database connection instance
$conn = $db->getConnection(); // Get the database connection

if ($conn->connect_error) {
    die("Connection failed: ");
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

if ($name == "" || $password == "") {
    $error = "Both name and password are required.";
} else {

    $check_sql = "SELECT * FROM users WHERE name = '$name' AND password = '$password'";
    $result = $conn->query($check_sql);

    if ($result && $result->num_rows > 0) {
         $error = "User already registered. Please go to login.";
    } else {
        $insert_sql = "INSERT INTO users (name, password) VALUES ('$name', '$password')";

        if ($conn->query($insert_sql) === TRUE) {
            $_SESSION['name'] = $name;
            header("Location: login.php");
            exit;
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
        <div class="alert alert-danger text-center">
            <?php echo $error; ?>
                </div>
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