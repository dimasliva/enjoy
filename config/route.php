<?php
$requestUri = $_SERVER['REQUEST_URI'];


if ($requestUri === HOME_PAGE['URL']) {
    require_once(HOME_PAGE['FILE']);
} else if ($requestUri === AUTH_PAGE['URL']) {
    require_once(AUTH_PAGE['FILE']);
} else if ($requestUri === LESSONS_PAGE['URL']) {
    require_once(LESSONS_PAGE['FILE']);
} else if ($requestUri === REGISTER_PAGE['URL']) {
    require_once(REGISTER_PAGE['FILE']);
} else if ($requestUri === ADMIN_PAGE['URL']) {
    require_once(ADMIN_PAGE['FILE']);
} else if ($requestUri === ADMIN_AUTH_PAGE['URL']) {
    require_once(ADMIN_AUTH_PAGE['FILE']);
}  elseif (preg_match('/^\/lesson\/(\d+)$/', $requestUri, $matches)) {
    require_once(LESSON_PAGE['FILE']);
}
?>