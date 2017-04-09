<?php
session_start();
unset($_SESSION['is_logged']);
unset($_SESSION['customer_id']);
unset($_SESSION['first_name']);
unset($_SESSION['last_name'] );
session_unset();
session_destroy();
header('Location: index.php');