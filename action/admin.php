<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Lesson.php");
session_start();

$userModel = new User();
$lessonModel = new Lesson();

$users = $userModel->getAllUsers();
$lessons = $lessonModel->getAllLessons(300, 0);
$accessLessons = $lessonModel->getAllAceessLesson();

if(!isset($_SESSION['role'])) {
    header("Location: ". ADMIN_AUTH_PAGE['URL']);
} else if($_SESSION['role'] !== 'admin')  {
    header("Location: ". HOME_PAGE['URL']);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        $userModel->updateUser($id, $name, $role);
        header('Location: ' . ADMIN_AUTH_PAGE['URL']);
        exit();
    }
    if(isset($_POST['delete'])) {
        $id = $_POST['id'];

        $userModel->deleteUser($id);
        header('Location: ' . ADMIN_AUTH_PAGE['URL']);
        exit();
    }
    if(isset($_POST['accessLesson'])) {
        $userId = $_POST['userId'];
        $lessonId = $_POST['lessonId'];
        $result = $lessonModel->addAccessToLesson($userId, $lessonId);
        header("Location: " . ADMIN_AUTH_PAGE['URL']);
    }
    if(isset($_POST['removeAccess'])) {
        $accessId = $_POST['accessLessonId'];
        $lessonModel->removeAccessFromLesson($accessId);
        header("Location: " . ADMIN_AUTH_PAGE['URL']);
    }
}

require_once("templates/admin/index.php");

?>