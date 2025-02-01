<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/User.php");
session_start();

$userModel = new User();

print_r($userModel->getLoginAttempts());
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $loginResult = $userModel->login($name, $password);
    
    if ($loginResult['success']) {
        $_SESSION['id'] = $loginResult['data']['id'];
        $_SESSION['name'] = $loginResult['data']['name'];
        $_SESSION['role'] = $loginResult['data']['role'];
        header("Location: ". ADMIN_PAGE['URL']);
        exit();
    } else {
        $errorMessage = $loginResult['message'];
    }
}

require_once("templates/admin_auth/index.php");
?>
