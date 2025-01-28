<?php
$requestUri = $_SERVER['REQUEST_URI'];


if ($requestUri === HOME_PAGE['URL']) {
    require_once(HOME_PAGE['FILE']);
} else if ($requestUri === AUTH_PAGE['URL']) {
    require_once(AUTH_PAGE['FILE']);
} else if ($requestUri === LESSONS_PAGE['URL']) {
    require_once(LESSONS_PAGE['FILE']);
} elseif (preg_match('/^\/question\/(\d+)$/', $requestUri, $matches)) {
    require_once(QUESTION_PAGE['FILE']);
}
?>