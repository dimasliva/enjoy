<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Database.php");

// interface LessonInterface
// {
//     public function getID(): int;
//     public function getName(): string;
//     public function getAll(int $limit, int $offset): array;
//     public function getTotalCount(): int;
// }

class Lesson
    // class Lesson implements LessonInterface
{
    private $conn;
    private $id;
    private $name;

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

    public function getAll($limit, $offset)
    {
        $sql = "SELECT * FROM lessons LIMIT ? OFFSET ?;";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        $lessons = [];

        while ($row = $result->fetch_assoc()) {
            $lessons[] = $row;
        }

        $stmt->close();

        return $lessons;
    }

    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as count FROM lessons;";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return (int) $row['count'];
    }
}
