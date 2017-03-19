<?php
ob_start();
session_start();
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'cyberlink_db');
define('DB_HOST', 'localhost');
define('DB_DSN', 'mysql:host=' . DB_HOST . ';port=3306;dbname=' . DB_NAME);

DEFINE('ROOT', $_SERVER['DOCUMENT_ROOT']);
DEFINE('PATH', 'cyberlink.com');


if (isset($_SESSION['login']) && $_SESSION['login']) {
        $designation = $_SESSION['user']['user_level'];
        $userid = $_SESSION['user']['uid'];
        $full_name = $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];
} else {
    //Header('Location: login');
}
