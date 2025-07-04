<?php
require_once 'admin/db.php';

class quizQuestions
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getAllQuestions() // Fetch all questions with options and answer
    {
        $questions = [];

        $sql = "SELECT id, question, option1, option2, option3, option4, answer FROM quiz_questions";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $questions[] = [
                    'id' => $row['id'],
                    'question' => $row['question'],
                    'options' => [
                        $row['option1'],
                        $row['option2'],
                        $row['option3'],
                        $row['option4']
                    ],
                    'answer' => $row['answer']
                ];
            }
        }
        return $questions;
    }
}
?>
