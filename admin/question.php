<?php
session_start();
require_once '../classes/UserManager.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    die();
}

$userManager = new UserManager();
$questions = $userManager->getAllQuestions();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quiz Questions</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>

    <h2>📚 All Quiz Questions</h2>

    <?php if (!empty($questions)): ?>
        <table>
            <tr>
                <th>Question</th>
                <th>Correct Answer</th>
            </tr>
            <?php foreach ($questions as $q): ?>
                <tr>
                    <td><?= $q['question'] ?></td>
                    <td><?= $q['answer'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No questions found in the database.</p>
    <?php endif; ?>

    <a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>