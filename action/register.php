<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/models/User.php");
session_start();

$userModel = new User();

if (isset($_POST['register'])) {
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    $repass = htmlspecialchars($_POST['repass']);
    if($password === $repass) {

    $data = $userModel->register($name, $password, 'admin');
    if($data['success'] === true) {
        $_SESSION['id'] = $data['data']['id'];
        $_SESSION['name'] = $data['data']['name'];
        $_SESSION['role'] = $data['data']['role']; 
        header("Location: ". LESSONS_PAGE['URL']);
    }
    }

}
require_once("templates/register/index.php");

?>