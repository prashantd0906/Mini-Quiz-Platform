<?php
class quizQuestions {
    public function addQuestion($question, $option1, $option2, $option3, $option4, $answer) {
        $conn = new mysqli('127.0.0.1', 'root', '', 'quiz_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $question = $conn->real_escape_string($question);
        $option1 = $conn->real_escape_string($option1);
        $option2 = $conn->real_escape_string($option2);
        $option3 = $conn->real_escape_string($option3);
        $option4 = $conn->real_escape_string($option4);
        $answer = $conn->real_escape_string($answer);

        $sql = "INSERT INTO quiz_questions (question, option1, option2, option3, option4, answer) 
                VALUES ('$question', '$option1', '$option2', '$option3', '$option4', '$answer')";

        return $conn->query($sql);
    }
}
?>
