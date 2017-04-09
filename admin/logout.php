<?php


unset($_SESSION['user']);
unset($_SESSION['login']);
session_unset();
session_destroy();
header('Location: login.php');