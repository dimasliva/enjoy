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

    public function getAllLessons($perPage, $offset)
    {
        $sql = "SELECT * FROM lessons LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $perPage, $offset); 

        $stmt->execute();
        $result = $stmt->get_result();
        $lessons = [];

        while ($row = $result->fetch_assoc()) {
            $lessons[] = $row;
        }

        $stmt->close();

        return $lessons;
    }


    public function addAccessToLesson($userId, $lessonId) {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as count 
            FROM user_lessons 
            WHERE user_id = ? AND lesson_id = ?
        ");

        $stmt->bind_param("ii", $userId, $lessonId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row['count'] > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();

        $stmt = $this->conn->prepare("
            INSERT INTO user_lessons(user_id, lesson_id)
            VALUES (?,?)
        ");

        $stmt->bind_param("ii", $userId, $lessonId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
    public function getAccessId($userId, $lessonId) {
        $stmt = $this->conn->prepare("
            SELECT id 
            FROM user_lessons 
            WHERE user_id = ? AND lesson_id = ?
        ");
    
    
        $stmt->bind_param("ii", $userId, $lessonId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['id'];
        }
    
        $stmt->close();
        return null; 
    }
    public function removeAccessFromLesson($accessId)  {
        $stmt = $this->conn->prepare("DELETE FROM user_lessons WHERE id = ?");

        $stmt->bind_param('i', $accessId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function getAllAceessLesson() {
        $sql = " SELECT ul.id, u.name AS username, l.name AS lesson_name
        FROM user_lessons ul
        JOIN users u ON ul.user_id = u.id
        JOIN lessons l ON ul.lesson_id = l.id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $result = $stmt->get_result();
        $accessLessons = [];

        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $lessonName = $row['lesson_name'];
    
            if (!isset($accessLessons[$username])) {
                $accessLessons[$username] = [
                    'lessons' => [],
                    'id' => $row['id'] 
                ];
            }
            $accessLessons[$username]['lessons'][] = $lessonName;
        }

        $stmt->close();

        $formattedAccessLessons = [];
        foreach ($accessLessons as $username => $data) {
            $formattedAccessLessons[] = [
                'username' => $username,
                'lesson_names' => implode(', ', $data['lessons']),
                'id' => $data['id']
            ];
        }
    
        return $formattedAccessLessons;
    }

    public function getLessonsForUser($userId, $perPage, $offset)
    {
        $stmt = $this->conn->prepare("
            SELECT l.id, l.name
            FROM lessons l
            JOIN user_lessons ul ON l.id = ul.lesson_id
            WHERE ul.user_id = ?
            LIMIT ?, ?
        ");

        if ($stmt === false) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        $stmt->bind_param("iii", $userId, $offset, $perPage);
        $stmt->execute();

        // Получаем результат
        $result = $stmt->get_result();
        $lessons = $result->fetch_all(MYSQLI_ASSOC);

        // Закрываем оператор
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
