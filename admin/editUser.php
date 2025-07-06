<?php
session_start();
require_once '../classes/UserManager.php';
$userManager = new UserManager();

$id = $_GET['id'] ?? 0;
$user = $userManager->getUserById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $score = $_POST['score'];
    $userManager->updateUser($id, $username, $score);
    header("Location: dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="mb-4 text-center"> Edit User</h3>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                    value="<?= $user['username'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Score</label>
                <input type="number" name="score" class="form-control"
                    value="<?= (string)($user['score'] ?? '') ?>" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>

</body>

</html>