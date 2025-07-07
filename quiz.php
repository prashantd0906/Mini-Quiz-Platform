<?php
session_start();

// direct access restricted
if (!isset($_SESSION['name']) || $_SESSION['role'] !== 'user') {
    header("Location: register.php");
    exit;
}

require_once 'admin/db.php';
require_once 'questions.php';

// DB connection
$db = new dbConnection('127.0.0.1', 'root', '', 'quiz_db');
$conn = $db->getConnection();

//quizQuestions class
$quiz = new quizQuestions($conn);
$questions = $quiz->getAllQuestions();
?>

<html>
<title>PHP Quiz</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<body class="bg-light p-4">

    <div class="container" style="max-width: 700px;">
        <h2 class="mb-4 text-center">📝 Take the Quiz</h2>

        <form action="result.php" method="post" class="bg-white p-4 rounded shadow-sm">
            <?php foreach ($questions as $q): ?>
                <div class="mb-4">
                    <strong><?= $q['question'] ?></strong><br><br>

                    <?php foreach ($q['options'] as $opt): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $opt ?>" required>
                            <label class="form-check-label"><?= $opt ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-success w-100">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
