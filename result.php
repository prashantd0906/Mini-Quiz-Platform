<?php
session_start();
require_once 'questions.php';
require_once 'admin/db.php';

// ❌ If user is not logged in, redirect to registration
if (!isset($_SESSION['name'])) {
    header("Location: register.php");
    exit;
}

// ❌ If no answers submitted via POST, block direct access and go to registration
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['answers'])) {
    header("Location: register.php");
    exit;
}

$db = new dbConnection();
$conn = $db->getConnection();

$quiz = new quizQuestions($conn);
$questions = $quiz->getAllQuestions();

// Get user's answers 
$userAnswers = $_POST['answers'];
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

// Save results
$userNameEscaped = $conn->real_escape_string($userName);

$checkSql = "SELECT id FROM quiz_results WHERE username = '$userNameEscaped'";
$result = $conn->query($checkSql);

if ($result->num_rows > 0) {
    $updateSql = "UPDATE quiz_results SET score = $totalscore, submitted_at = NOW() WHERE username = '$userNameEscaped'";
    $conn->query($updateSql);
} else {
    $insertSql = "INSERT INTO quiz_results (username, score, submitted_at) VALUES ('$userNameEscaped', $totalscore, NOW())";
    $conn->query($insertSql);
}
?>
