<?php
session_start();
require_once '../classes/UserManager.php';

$userManager = new UserManager();
$id = $_GET['id'] ?? 0; //geting users id

// Fetch single user
$user = $userManager->getUserById($id);
if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        $userManager->deleteUser($id);
        header("Location: dashboard.php");
        exit;
    }
    if (isset($_POST['cancel'])) {
        header("Location: dashboard.php");
        exit;
    }
}
?>

<html>
<title>Delete User</title>

<body>

    <h3>Are you sure you want to delete user <strong><?= $user['username'] ?></strong>?</h3>
    <form method="post" action="">
        <button type="submit" name="confirm_delete">Yes, Delete</button>
        <button type="submit" name="cancel">Cancel</button>
    </form>
</body>

</html>