<?php
class quizQuestions {
    public function addQuestion($q, $o1, $o2, $o3, $o4, $correct) {
        $conn = new mysqli('127.0.0.1', 'root', '', 'quiz_db');

        if ($conn->connect_error) {
            die("Connection failed: ");
        }

        $q = $conn->real_escape_string($q);
        $o1 = $conn->real_escape_string($o1);
        $o2 = $conn->real_escape_string($o2);
        $o3 = $conn->real_escape_string($o3);
        $o4 = $conn->real_escape_string($o4);
        $correct = (int)$correct;

        $sql = "INSERT INTO quiz_questions (question, option1, option2, option3, option4, answer) 
                VALUES ('$q', '$o1', '$o2', '$o3', '$o4', $correct)";

        return $conn->query($sql);
    }
}
?>
