<?php

	session_start();

     if(isset($_COOKIE['jjf_username']) && isset($_COOKIE['jjf_password']) && isset($_SESSION['user'])) {

            unset($_COOKIE['jjf_username']);
            unset($_COOKIE['jjf_password']);
            setcookie('jjf_username', '', time() - 3600);
            setcookie('jjf_password', '', time() - 3600);
            unset($_SESSION['user']);

        } else {

            unset($_SESSION['user']);

        }

	header("Location:".$_SERVER['HTTP_REFERER']);

?>