<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Database.php");

// interface QuestionInterface
// {
//     public function getID(): int;
//     public function getName(): string;
//     public function getAll(): array;
//     public function getByLessonId(int $id): array;
//     public function addAnswer(int $question_id, int $user_id, string $answer): bool;
// }

class Question
    // class Question implements QuestionInterface
{
    private $conn;
    private $id;
    private $name;
    private $role;
    public function __construct()
    {
        $this->conn = Database::getConnection();
    }
    public function getID()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM questions;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $Questions = [];
        while ($row = $result->fetch_assoc()) {
            $Questions[] = $row;
        }
        return $Questions;
    }
    public function getByLessonId($id)
    {
        $sql = "SELECT * FROM questions where lesson_id=?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
        return $questions;
    }
    public function addAnswer(int $question_id, int $user_id, string $answer): bool
    {
        $sql = "INSERT INTO answer_questions (question_id, user_id, answer) VALUES (?, ?, ?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $question_id, $user_id, $answer);

        if ($stmt->execute()) {
            return true; // Успешное добавление
        } else {
            return false; // Ошибка при добавлении
        }
    }
}