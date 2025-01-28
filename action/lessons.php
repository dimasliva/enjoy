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
    header("Location: " . QUESTION_PAGE['URL'] . '/' . $_POST['to_lesson']);
    exit(); // Не забудьте добавить exit после header
}

if (isset($_POST['exit'])) {
    $_SESSION['id'] = null;
    $_SESSION['name'] = null;
    $_SESSION['role'] = null;
    header('Location: ' . HOME_PAGE['URL']);
    exit(); // Не забудьте добавить exit после header
}

if (isset($_POST['changePage'])) {
    $currentPage = (int)$_POST['changePage'];
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;
}

$lessons = $lessonModel->getAll($perPage, $offset);

require_once("templates/lessons/index.php");