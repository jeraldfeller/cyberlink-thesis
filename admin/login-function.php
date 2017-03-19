<?php
require 'Model/Init.php';
require 'Model/User.php';
$userClass = new User();

if (isset($_POST['userName']) && isset($_POST['password'])) {
// take security precautions: filter all incoming data!
    $userName 		= (isset($_POST['userName'])) 		? strip_tags($_POST['userName']) 		: '';
    $password 	= (isset($_POST['password'])) 	? strip_tags($_POST['password']) 	: '';
    if ($userName && $password) {
        $result = $userClass->login($userName, $password);
        if ($result) {
// store user info in session
            $_SESSION['user'] = $result;
            $_SESSION['login'] = TRUE;
            if(isset($_SESSION['user'])){
                foreach($result as $row)
                {
                        Header('Location: index');
                }
            }

// redirect back home
        }
        else {
            Header('Location: login?msg=error');
        }
        exit;
    }else{
        Header('Location: login?msg=error');
    }
}else{
    Header('Location: login?msg=error');
}





?>