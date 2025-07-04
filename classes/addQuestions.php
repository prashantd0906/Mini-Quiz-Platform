<?php
class quizQuestions {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addQuestion(array $data) {
        foreach ($data as $key => $value) {
            $data[$key] = $this->conn->real_escape_string($value);
        }

        $sql = "INSERT INTO quiz_questions (question, option1, option2, option3, option4, answer)
                VALUES (
                    '{$data['question']}',
                    '{$data['option1']}',
                    '{$data['option2']}',
                    '{$data['option3']}',
                    '{$data['option4']}',
                    '{$data['answer']}'
                )";

        return $this->conn->query($sql);
    }
}
?>
