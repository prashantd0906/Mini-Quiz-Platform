<?php
class quizQuestions
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('127.0.0.1', 'root', '', 'quiz_db');
        if ($this->conn->connect_error) {
            die("connection failed: ");
        }
    }

    public function getAllQuestions()
    {
        $questions = [];
        $result = $this->conn->query("SELECT * FROM quiz_questions");

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
