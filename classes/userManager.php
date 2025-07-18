<?php
require_once __DIR__ . '/../admin/db.php';

interface userInterface
{
    public function getUsers(string $keyword = ''): array;
}
class UserManager extends dbConnection implements userInterface
{
    public function getUsers(string $keyword = ''): array
    {
        $columns = ['id', 'username', 'score', 'submitted_at'];
        $columnList = implode(',', $columns);

        if (!empty($keyword)) {
            $keyword = $this->conn->real_escape_string($keyword);
            $sql = "SELECT $columnList FROM quiz_results WHERE username LIKE '%$keyword%' ORDER BY score DESC";
        } else {
            $sql = "SELECT $columnList FROM quiz_results ORDER BY score DESC";
        }
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllUsersSorted(string $order = 'ASC'): array
    {
        $columns = ['id', 'username', 'score', 'submitted_at'];
        $columnList = implode(',', $columns);

        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sql = "SELECT $columnList FROM quiz_results ORDER BY username $order";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id)
    {
        $columns = ['id', 'username', 'score', 'submitted_at'];
        $columnList = implode(',', $columns);

        $id = (int)$id;
        $sql = "SELECT $columnList FROM quiz_results WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc(); // returns 1 record
    }

    public function getAllQuestions()
    {
        $sql = "SELECT question, answer FROM quiz_questions";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateUser($id, $username, $score): bool
    {
        $id = (int)$id;
        $username = $this->conn->real_escape_string($username);
        $score = (int)$score;
        $sql = "UPDATE quiz_results SET username='$username', score=$score WHERE id=$id";
        return $this->conn->query($sql);
    }

    public function deleteUser($id): bool
    {
        $id = (int)$id;
        $sql = "DELETE FROM quiz_results WHERE id = $id";
        return $this->conn->query($sql);
    }
}
