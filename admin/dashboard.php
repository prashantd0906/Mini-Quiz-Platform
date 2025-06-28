<?php
session_start();
require_once '../classes/UserManager.php';
$userManager = new UserManager();

$sort_option = 'ASC';
if (isset($_GET['sort_alphabet']) && $_GET['sort_alphabet'] === 'z-a') {
    $sort_option = 'DESC';
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $users = $userManager->searchUsers($_GET['search']);
} else {
    $users = $userManager->getAllUsersSorted($sort_option);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="./css/dashboard.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Admin Dashboard</h2>
        <div>
            <a href="question.php" class="btn btn-dark me-2">View Questions</a>
            <form action="logout.php" method="post" class="d-inline">
                <button class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <form method="get" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search username"
                value="<?= $_GET['search'] ?? '' ?>">
        </div>
        <div class="col-md-4">
            <select name="sort_alphabet" class="form-select">
                <option value=""> Sort Username </option>
                <option value="a-z" <?= ($_GET['sort_alphabet'] ?? '') === 'a-z' ? 'selected' : '' ?>>A-Z</option>
                <option value="z-a" <?= ($_GET['sort_alphabet'] ?? '') === 'z-a' ? 'selected' : '' ?>>Z-A</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Apply</button>
        </div>
    </form>

    <?php if (!empty($users)): ?>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Score</th>
                    <th>Submitted</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['score'] ?></td>
                        <td><?= $user['submitted_at'] ?></td>
                        <td><a href="editUser.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-light">Edit</a></td>
                        <td><a href="deleteUser.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')" class="btn btn-sm btn-light">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-muted">No quiz records found.</p>
    <?php endif; ?>

</body>
</html>