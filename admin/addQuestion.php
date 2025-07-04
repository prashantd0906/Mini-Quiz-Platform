<?php
require_once 'db.php';
require_once '../classes/addQuestions.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionData = [
        'question' => $_POST['question'] ?? '',
        'option1'  => $_POST['option1'] ?? '',
        'option2'  => $_POST['option2'] ?? '',
        'option3'  => $_POST['option3'] ?? '',
        'option4'  => $_POST['option4'] ?? '',
        'answer'   => $_POST['correct_answer'] ?? ''
    ];

    if (in_array('', $questionData)) {
        $msg = "<div class='alert alert-danger'>Please fill in all fields.</div>";
    } else {
        $db = new dbConnection();
        $conn = $db->getConnection();
        $quiz = new quizQuestions($conn);

        $msg = $quiz->addQuestion($questionData)
            ? "<div class='alert alert-success'>Question added successfully!</div>"
            : "<div class='alert alert-danger'>Failed to add question.</div>";
    }
}
?>



<html>
<title>Add Question</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<body class="container py-4">
    <h2 class="mb-3">+ Add Question</h2>
    <?= $msg ?>

    <form method="POST">
        <input type="text" name="question" class="form-control mb-2" placeholder="Enter question" required>
        <input type="text" name="option1" class="form-control mb-2" placeholder="Option 1" required>
        <input type="text" name="option2" class="form-control mb-2" placeholder="Option 2" required>
        <input type="text" name="option3" class="form-control mb-2" placeholder="Option 3" required>
        <input type="text" name="option4" class="form-control mb-2" placeholder="Option 4" required>
        <input type="text" name="correct_answer" min="1" max="4" class="form-control mb-3" placeholder="Correct option" required>
        <button type="submit" class="btn btn-primary">Add</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</body>

</html>