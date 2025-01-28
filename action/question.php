<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Question.php");
session_start();
$questionModel = new Question();



$parseUrl = parse_url($_SERVER['REQUEST_URI'])['path'];
$segments = explode('/', $parseUrl);
$id = end($segments);
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit'])) {


    foreach ($_POST['answer'] as $question_id => $answer) {
        $questionModel->addAnswer($question_id, $_SESSION['id'], $answer);
    }
    header("Location: " . QUESTION_PAGE['URL'] . '/' . $id);
}
$questions = $questionModel->getByLessonId($id);

require_once("templates/question/index.php");

?>