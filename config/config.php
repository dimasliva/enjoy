<?php
$env = parse_ini_file(".env");
define("DB_HOST", $env["DB_HOST"]);
define("DB_USER", $env["DB_USER"]);
define("DB_PASS", $env["DB_PASS"]);
define("DB_NAME", $env["DB_NAME"]);

const LOGO_NAME = "EnjoyEnglish";
const URL_SITE = "https://enjoy/";
const IMGS_PATH = "/css/images";
const SVGS_PATH = "./css/svgs";
const TEMPLATES_PATH = "/templates";
const JS_PATH = "/css/js";

const HOME_PAGE = [
    'URL' => '/',
    'NAME' => 'Главная',
    'FILE' => 'action/home.php',
    'FOLDER' => '/templates/home',
];
const AUTH_PAGE = [
    'URL' => '/auth',
    'NAME' => 'Войти',
    'FILE' => 'action/auth.php',
    'FOLDER' => '/templates/auth',
];
const LESSONS_PAGE = [
    'URL' => '/lessons',
    'NAME' => 'Уроки',
    'FILE' => 'action/lessons.php',
    'FOLDER' => '/templates/lessons',
];
const QUESTION_PAGE = [
    'URL' => '/question',
    'NAME' => 'Вопросы',
    'FILE' => 'action/question.php',
    'FOLDER' => '/templates/question',
];
?>