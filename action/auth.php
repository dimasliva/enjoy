<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/User.php");
session_start();
$userModel = new User();

if (isset($_POST['login'])) {
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    $data = $userModel->login($name, $password);
    if ($data['success']) {

        $_SESSION['id'] = $data['data']['id'];
        $_SESSION['name'] = $data['data']['name'];
        $_SESSION['role'] = $data['data']['role'];
        header('Location: ' . LESSONS_PAGE['URL']);
    }
}
require_once("templates/auth/index.php");
?>