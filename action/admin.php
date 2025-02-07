<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Lesson.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Question.php");
session_start();

$userModel = new User();
$lessonModel = new Lesson();
$questionModel = new Question();

$users = $userModel->getAllUsers();
$lessons = $lessonModel->getAllLessons(300, 0);
$accessLessons = $lessonModel->getAllAceessLesson();

if(!isset($_SESSION['role'])) {
    header("Location: ". ADMIN_AUTH_PAGE['URL']);
} else if($_SESSION['role'] !== 'admin')  {
    header("Location: ". HOME_PAGE['URL']);
}

$directory = $_SERVER['DOCUMENT_ROOT'].'/uploads';
$files = scandir($directory);
$questions = $questionModel->getAll();


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_question'])) {
        $id = $_POST['id'];
        $lesson_id = $_POST['lesson_id'];
        $text = $_POST['text']; 

        $questionModel->update($id, $text, $lesson_id); 
        header('Location: ' . ADMIN_PAGE['URL']);
        exit();
    }
    if (isset($_POST['delete_question'])) {
        $id = $_POST['id'];

        $questionModel->delete($id);
        header('Location: ' . ADMIN_PAGE['URL']);
        exit();
    }
    if (isset($_POST['add_question'])) {
        $lesson_id = $_POST['lesson_id'];
        $text = $_POST['text'];

        $questionModel->add($text, $lesson_id); 
        header('Location: ' . ADMIN_PAGE['URL']);
        exit();
    }
    if(isset($_POST['edit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        $userModel->updateUser($id, $name, $role);
        header('Location: ' . ADMIN_PAGE['URL']);
        exit();
    }
    if(isset($_POST['delete'])) {
        $id = $_POST['id'];

        $userModel->deleteUser($id);
        header('Location: ' . ADMIN_PAGE['URL']);
        exit();
    }
    if (isset($_POST['accessLesson'])) {
        if (isset($_POST['userId']) && isset($_POST['lessonId']) && 
            is_numeric($_POST['userId']) && is_numeric($_POST['lessonId'])) {
            
            $userId = (int)$_POST['userId'];
            $lessonId = (int)$_POST['lessonId'];
            
            $result = $lessonModel->addAccessToLesson($userId, $lessonId);
            header("Location: " . ADMIN_PAGE['URL']);
        } else {
            header("Location: " . ADMIN_PAGE['URL']);
        }
    }
    if (isset($_POST['change_password'])) {
        $id = $_POST['id'];
        $newPassword = $_POST['new_password'];

        $userModel->changePassword($id, $newPassword);
 

        header('Location: ' . ADMIN_PAGE['URL']);
        exit();
    }
    if(isset($_POST['removeAccess'])) {
        $accessId = $_POST['accessLessonId'];
        $lessonModel->removeAccessFromLesson($accessId);
        header("Location: " . ADMIN_PAGE['URL']);
    }
    if(isset($_POST['delete_file'])) {
        $fileToDelete = $_POST['file'];
        $filePath = $directory . '/' . $fileToDelete;

        if(file_exists($filePath)) {
            unlink($filePath);
        }
        header("Location: " . ADMIN_PAGE['URL']);
        exit();
    }
}

require_once("templates/admin/index.php");

?>