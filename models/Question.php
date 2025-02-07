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
        $sql = "SELECT questions.id, questions.text, questions.lesson_id, lessons.name AS lesson_name 
        FROM questions 
        LEFT JOIN lessons ON questions.lesson_id = lessons.id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
        return $questions;
    }

    public function getByLessonId($id)
    {
        $sql = "SELECT * FROM questions WHERE lesson_id=?;";
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

    public function add(string $text, int $lesson_id): bool
    {
        $sql = "INSERT INTO questions (text, lesson_id) VALUES (?, ?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $text, $lesson_id);

        return $stmt->execute(); 
    }

    public function update(int $id, string $text, int $lesson_id): bool
    {
        $sql = "UPDATE questions SET text=?, lesson_id=? WHERE id=?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $text, $lesson_id, $id);

        return $stmt->execute(); 
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM questions WHERE id=?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function addAnswer(int $question_id, int $user_id, string $answer): bool
    {
        $sql = "INSERT INTO answer_questions (question_id, user_id, answer) VALUES (?, ?, ?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $question_id, $user_id, $answer);

        return $stmt->execute(); 
    }
}
