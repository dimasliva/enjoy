<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Question.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Lesson.php");

session_start();

$questionModel = new Question();
$lessonModel = new Lesson();

$parseUrl = parse_url($_SERVER['REQUEST_URI'])['path'];
$segments = explode('/', $parseUrl);
$id = end($segments);

$accessibleLessons = $lessonModel->getLessonsForUser($_SESSION['id'], 300, 0);
$accessibleLessonIds = array_column($accessibleLessons, 'id');
if ($_SESSION['role'] !== 'admin') {
    if (!in_array($id, $accessibleLessonIds)) {
        header("Location: " . LESSONS_PAGE['URL']);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit'])) {
    $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads";
    
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    $userName = preg_replace('/[^a-zA-Z0-9_]/', '_', $_SESSION['name']);
    $date = date('Y-m-d_H-i-s'); 
    $fileName = "{$userName}_{$date}.txt"; 
    $filePath = $uploadsDir . "/$fileName";

    foreach ($_POST['answer'] as $question_id => $answer) {
        $questionText = $_POST['question_text'][$question_id] ?? 'Вопрос не найден'; 

        $questionModel->addAnswer($question_id, $_SESSION['id'], $answer);
        $dataToWrite = "Question: $questionText; Answer: " . htmlspecialchars($answer) . "\n";
        file_put_contents($filePath, $dataToWrite, FILE_APPEND);
    }
    $accessId = $lessonModel->getAccessId($_SESSION['id'], $id);
    if($accessId != null) {
        $lessonModel->removeAccessFromLesson($accessId);
    }
    header("Location: " . LESSON_PAGE['URL'] . '/' . $id);
}

$questions = $questionModel->getByLessonId($id);

require_once("templates/lesson/index.php");
?>
