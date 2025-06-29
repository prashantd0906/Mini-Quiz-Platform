<?php
session_start();
require_once 'questions.php';
require_once 'admin/db.php';
$db = new dbConnection();
$conn = $db->getConnection();

// Get all questions
$quiz = new quizQuestions();
$questions = $quiz->getAllQuestions();

// Get user's answers 
$userAnswers = $_POST['answers'] ?? [];
$totalscore = 0;

// Check answers
foreach ($questions as $q) {
    $questionId = $q['id'];
    if (isset($userAnswers[$questionId]) && $userAnswers[$questionId] == $q['answer']) {
        $totalscore++;
    }
}

// Show result
$userName = $_SESSION['name'];
$totalQuestions = count($questions);

echo "<h2>Hello, $userName! Thanks for taking up the quiz.</h2>";
echo "<p><strong>Your score is: </strong><strong>$totalscore / $totalQuestions</strong></p>";
echo '<a href="logout.php" class="btn btn-danger mt-3">Logout</a>';

//real_escape_string
$userNameEscaped = $conn->real_escape_string($userName); //prevent breaking of SQL query 
$checkSql = "SELECT id FROM quiz_results WHERE username = '$userNameEscaped'";
$result = $conn->query($checkSql);

if ($result->num_rows > 0) {
    $updateSql = "UPDATE quiz_results SET score = $totalscore, submitted_at = NOW() WHERE username = '$userNameEscaped'";
    $conn->query($updateSql);
} else {
    $insertSql = "INSERT INTO quiz_results (username, score, submitted_at) VALUES ('$userNameEscaped', $totalscore, NOW())";
    $conn->query($insertSql);
}
