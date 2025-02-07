<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Lesson.php");
session_start();

$lessonModel = new Lesson();
$totalLessons = $lessonModel->getTotalCount();
$perPage = 50;
$offset = 0;
$currentPage = 1;
$totalPages = ceil($totalLessons / $perPage);

if (isset($_POST['to_lesson'])) {
    header("Location: " . LESSON_PAGE['URL'] . '/' . $_POST['to_lesson']);
}
if (isset($_POST['disable_lesson'])) {
    header("Location: " . LESSONS_PAGE['URL']);
    exit();
}

if (isset($_POST['exit'])) {
    $_SESSION['id'] = null;
    $_SESSION['name'] = null;
    $_SESSION['role'] = null;
    header('Location: ' . HOME_PAGE['URL']);
    exit();
}

$accessibleLessons = $lessonModel->getLessonsForUser($_SESSION['id'], $perPage, $offset);

$accessibleLessonIds = array_column($accessibleLessons, 'id');
if (isset($_POST['changePage'])) {
    if (!empty($accessibleLessonIds)  || $_SESSION['role'] === 'admin') {
        $currentPage = (int) $_POST['changePage'];
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset = ($currentPage - 1) * $perPage;
    } else {
        header("Location: " . LESSONS_PAGE['URL']);
        exit();
    }
}
$allLessons = $lessonModel->getAllLessons($perPage, $offset);


require_once("templates/lessons/index.php");

